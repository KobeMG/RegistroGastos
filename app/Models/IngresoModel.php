<?php

namespace App\Models;

use CodeIgniter\Model;

class IngresoModel extends Model
{
    protected $table            = 'ingresos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['usuario_id', 'monto', 'tipo', 'descripcion', 'fecha_ingreso', 'es_recurrente', 'periodo'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'usuario_id'     => 'required|integer',
        'monto'          => 'required|decimal',
        'tipo'           => 'required|in_list[ordinario,extraordinario]',
        'fecha_ingreso'  => 'required|valid_date'
    ];
    
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['validarPeriodoNoCerrado'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['validarPeriodoNoCerrado'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Valida que no se pueda crear/editar un ingreso en un mes ya cerrado.
     */
    protected function validarPeriodoNoCerrado(array $data): array
    {
        if (!isset($data['data']['fecha_ingreso']) || !isset($data['data']['usuario_id'])) {
            return $data;
        }

        $fecha = $data['data']['fecha_ingreso'];
        $periodo = date('Y-m', strtotime($fecha));
        [$anio, $mes] = explode('-', $periodo);

        $cierreModel = new \App\Models\CierreModel();
        $cierre = $cierreModel
            ->where('usuario_id', $data['data']['usuario_id'])
            ->where('anio', (int) $anio)
            ->where('mes', (int) $mes)
            ->first();

        if ($cierre) {
            throw new \RuntimeException("No se puede modificar ingresos de un período cerrado ({$periodo}).");
        }

        // Asignar período automáticamente.
        $data['data']['periodo'] = $periodo;

        return $data;
    }

    /**
     * Obtener todos los ingresos de un usuario
     */
    public function getIngresosPorUsuario($usuarioId)
    {
        return $this->where('usuario_id', $usuarioId)
                    ->orderBy('fecha_ingreso', 'DESC')
                    ->findAll();
    }

    /**
     * Obtener ingresos por tipo (ordinarios o extraordinarios)
     */
    public function getIngresosPorTipo($usuarioId, $tipo)
    {
        return $this->where('usuario_id', $usuarioId)
                    ->where('tipo', $tipo)
                    ->orderBy('fecha_ingreso', 'DESC')
                    ->findAll();
    }

    /**
     * Calcular total de ingresos por tipo
     */
    public function getTotalPorTipo($usuarioId, $tipo)
    {
        $result = $this->selectSum('monto')
                       ->where('usuario_id', $usuarioId)
                       ->where('tipo', $tipo)
                       ->first();
        
        return $result['monto'] ?? 0;
    }

    /**
     * Calcular total de todos los ingresos
     */
    public function getTotalIngresos($usuarioId)
    {
        $result = $this->selectSum('monto')
                       ->where('usuario_id', $usuarioId)
                       ->first();
        
        return $result['monto'] ?? 0;
    }

    /**
     * Obtener ingresos por rango de fechas
     */
    public function getIngresosPorFechas($usuarioId, $fechaInicio, $fechaFin)
    {
        return $this->where('usuario_id', $usuarioId)
                    ->where('fecha_ingreso >=', $fechaInicio)
                    ->where('fecha_ingreso <=', $fechaFin)
                    ->orderBy('fecha_ingreso', 'DESC')
                    ->findAll();
    }

    /**
     * Obtener ingresos agrupados por mes
     */
    public function getIngresosPorMes($usuarioId, $limite = 6)
    {
        return $this->select('YEAR(fecha_ingreso) as anio, MONTH(fecha_ingreso) as mes, SUM(monto) as total')
                    ->where('usuario_id', $usuarioId)
                    ->groupBy('YEAR(fecha_ingreso), MONTH(fecha_ingreso)')
                    ->orderBy('YEAR(fecha_ingreso) DESC, MONTH(fecha_ingreso) DESC')
                    ->limit($limite)
                    ->findAll();
    }

    /**
     * Obtener ingresos agrupados por tipo para un período
     */
    public function getIngresosPorTipoMes($usuarioId, $limite = 6)
    {
        return $this->select('YEAR(fecha_ingreso) as anio, MONTH(fecha_ingreso) as mes, tipo, SUM(monto) as total')
                    ->where('usuario_id', $usuarioId)
                    ->groupBy('YEAR(fecha_ingreso), MONTH(fecha_ingreso), tipo')
                    ->orderBy('YEAR(fecha_ingreso) DESC, MONTH(fecha_ingreso) DESC')
                    ->limit($limite * 2)
                    ->findAll();
    }
}
