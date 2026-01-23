<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsuarioModel;
use App\Models\IngresoModel;
use App\Models\GastoModel;
use App\Models\CategoriaModel;

class DashboardFinanciero extends BaseController
{
    protected $usuarioModel;
    protected $ingresoModel;
    protected $gastoModel;
    protected $categoriaModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->ingresoModel = new IngresoModel();
        $this->gastoModel = new GastoModel();
        $this->categoriaModel = new CategoriaModel();
    }

    /**
     * Mostrar el dashboard financiero con gráficos comparativos
     */
    public function index()
    {
        // Verificar si el usuario está logueado
        if (!session()->get('logueado')) {
            return redirect()->to(base_url('auth'));
        }

        $usuarioId = session()->get('usuario_id');
        
        // Obtener totales generales
        $totalIngresos = $this->ingresoModel->getTotalIngresos($usuarioId);
        $totalGastos = $this->gastoModel->getTotalGastos($usuarioId);
        $balance = $totalIngresos - $totalGastos;
        
        // Obtener ingresos por tipo
        $totalOrdinarios = $this->ingresoModel->getTotalPorTipo($usuarioId, 'ordinario');
        $totalExtraordinarios = $this->ingresoModel->getTotalPorTipo($usuarioId, 'extraordinario');
        
        // Obtener datos mensuales (últimos 6 meses)
        $ingresosPorMes = $this->ingresoModel->getIngresosPorMes($usuarioId, 6);
        $gastosPorMes = $this->gastoModel->getGastosPorMes($usuarioId, 6);
        
        // Obtener gastos por categoría
        $gastosPorCategoria = $this->gastoModel->getGastosPorCategoria($usuarioId);
        
        // Obtener ingresos por tipo y mes
        $ingresosPorTipoMes = $this->ingresoModel->getIngresosPorTipoMes($usuarioId, 6);
        
        // Preparar datos para gráficos
        $meses = [];
        $ingresosArray = [];
        $gastosArray = [];
        
        // Crear array de meses combinando ingresos y gastos
        $mesesMap = [];
        
        foreach ($ingresosPorMes as $ingreso) {
            $key = $ingreso['anio'] . '-' . str_pad($ingreso['mes'], 2, '0', STR_PAD_LEFT);
            $mesesMap[$key] = [
                'mes' => $this->getNombreMes($ingreso['mes']) . ' ' . $ingreso['anio'],
                'ingresos' => $ingreso['total'],
                'gastos' => 0
            ];
        }
        
        foreach ($gastosPorMes as $gasto) {
            $key = $gasto['anio'] . '-' . str_pad($gasto['mes'], 2, '0', STR_PAD_LEFT);
            if (isset($mesesMap[$key])) {
                $mesesMap[$key]['gastos'] = $gasto['total'];
            } else {
                $mesesMap[$key] = [
                    'mes' => $this->getNombreMes($gasto['mes']) . ' ' . $gasto['anio'],
                    'ingresos' => 0,
                    'gastos' => $gasto['total']
                ];
            }
        }
        
        // Ordenar por fecha descendente y tomar solo 6 meses
        krsort($mesesMap);
        $mesesMap = array_slice($mesesMap, 0, 6);
        $mesesMap = array_reverse($mesesMap);
        
        foreach ($mesesMap as $datos) {
            $meses[] = $datos['mes'];
            $ingresosArray[] = $datos['ingresos'];
            $gastosArray[] = $datos['gastos'];
        }
        
        $data = [
            'totalIngresos' => $totalIngresos,
            'totalGastos' => $totalGastos,
            'balance' => $balance,
            'totalOrdinarios' => $totalOrdinarios,
            'totalExtraordinarios' => $totalExtraordinarios,
            'meses' => json_encode($meses),
            'ingresos' => json_encode($ingresosArray),
            'gastos' => json_encode($gastosArray),
            'gastosPorCategoria' => $gastosPorCategoria,
            'usuario' => $this->usuarioModel->find($usuarioId),
            'categorias' => $this->categoriaModel->findAll()
        ];

        return view('dashboard_financiero/index', $data);
    }

    /**
     * Obtener nombre del mes en español
     */
    private function getNombreMes($numeroMes)
    {
        $meses = [
            1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr',
            5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago',
            9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'
        ];
        
        return $meses[$numeroMes] ?? '';
    }
}
