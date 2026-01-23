<?php

namespace App\Services;

use App\Models\CierreModel;
use App\Models\GastoModel;
use App\Models\IngresoModel;
use Config\Database;
use DateTimeImmutable;
use Throwable;

class CierreMesService
{
    /**
     * Valida si el mes anterior ya tiene cierre; si no, lo genera de forma idempotente.
     */
    public function asegurarCierreMesAnterior(int $usuarioId): void
    {
        $hoy = new DateTimeImmutable('now');
        $periodo = $hoy->modify('first day of last month');
        $anio = (int) $periodo->format('Y');
        $mes = (int) $periodo->format('m');

        $cierreModel = new CierreModel();

        if ($cierreModel->where(['usuario_id' => $usuarioId, 'anio' => $anio, 'mes' => $mes])->first()) {
            return;
        }

        $fechaInicio = $periodo->format('Y-m-01');
        $fechaFin = $periodo->modify('last day of this month')->format('Y-m-d');

        $db = Database::connect();

        try {
            $db->transStart();

            // Revalidar dentro de la transacción para evitar duplicados en concurrencia.
            if ($cierreModel->where(['usuario_id' => $usuarioId, 'anio' => $anio, 'mes' => $mes])->first()) {
                $db->transComplete();
                return;
            }

            $ingresoModel = new IngresoModel();
            $gastoModel = new GastoModel();

            $totalIngresos = (float) ($ingresoModel
                ->selectSum('monto')
                ->where('usuario_id', $usuarioId)
                ->where('fecha_ingreso >=', $fechaInicio)
                ->where('fecha_ingreso <=', $fechaFin)
                ->first()['monto'] ?? 0);

            $totalGastos = (float) ($gastoModel
                ->selectSum('monto')
                ->where('usuario_id', $usuarioId)
                ->where('fecha_gasto >=', $fechaInicio)
                ->where('fecha_gasto <=', $fechaFin)
                ->first()['monto'] ?? 0);

            $cierreModel->insert([
                'usuario_id'     => $usuarioId,
                'anio'           => $anio,
                'mes'            => $mes,
                'total_ingresos' => $totalIngresos,
                'total_gastos'   => $totalGastos,
                'balance'        => $totalIngresos - $totalGastos,
                'generado_en'    => date('Y-m-d H:i:s'),
            ]);

            // Generar ingresos recurrentes para el nuevo mes.
            $this->generarIngresosRecurrentes($usuarioId, $ingresoModel);

            $db->transComplete();
        } catch (Throwable $e) {
            // Loguea y no bloquea el login en caso de fallo del cierre.
            log_message('error', 'Fallo al generar cierre de mes: {message}', ['message' => $e->getMessage()]);
            if ($db->transStatus() === false) {
                $db->transComplete();
            }
        }
    }

    /**
     * Genera los ingresos recurrentes para el mes actual basándose en los del mes anterior.
     */
    private function generarIngresosRecurrentes(int $usuarioId, IngresoModel $ingresoModel): void
    {
        $hoy = new DateTimeImmutable('now');
        $mesActual = $hoy->format('Y-m');

        // Buscar ingresos recurrentes del mes anterior.
        $mesAnterior = $hoy->modify('first day of last month')->format('Y-m');
        
        $recurrentes = $ingresoModel
            ->where('usuario_id', $usuarioId)
            ->where('es_recurrente', true)
            ->where('periodo', $mesAnterior)
            ->findAll();

        foreach ($recurrentes as $ingreso) {
            // Verificar si ya existe una copia para el mes actual.
            $existe = $ingresoModel
                ->where('usuario_id', $usuarioId)
                ->where('es_recurrente', true)
                ->where('periodo', $mesActual)
                ->where('descripcion', $ingreso['descripcion'])
                ->where('monto', $ingreso['monto'])
                ->first();

            if (!$existe) {
                // Calcular la fecha de ingreso para el nuevo mes (mismo día o último día del mes si no existe).
                $diaOriginal = (int) (new DateTimeImmutable($ingreso['fecha_ingreso']))->format('d');
                $ultimoDiaMes = (int) $hoy->modify('last day of this month')->format('d');
                $diaAjustado = min($diaOriginal, $ultimoDiaMes);
                
                $nuevaFecha = $hoy->setDate(
                    (int) $hoy->format('Y'),
                    (int) $hoy->format('m'),
                    $diaAjustado
                )->format('Y-m-d');

                $ingresoModel->insert([
                    'usuario_id'     => $usuarioId,
                    'monto'          => $ingreso['monto'],
                    'tipo'           => $ingreso['tipo'],
                    'descripcion'    => $ingreso['descripcion'],
                    'fecha_ingreso'  => $nuevaFecha,
                    'es_recurrente'  => true,
                    'periodo'        => $mesActual,
                ]);
            }
        }
    }
}
