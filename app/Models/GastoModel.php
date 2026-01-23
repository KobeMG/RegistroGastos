<?php

namespace App\Models;

use CodeIgniter\Model;

class GastoModel extends Model
{
    protected $table            = 'gastos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = ['usuario_id', 'categoria_id', 'monto', 'descripcion', 'fecha_gasto', 'periodo'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
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
     * Valida que no se pueda crear/editar un gasto en un mes ya cerrado.
     */
    protected function validarPeriodoNoCerrado(array $data): array
    {
        if (!isset($data['data']['fecha_gasto']) || !isset($data['data']['usuario_id'])) {
            return $data;
        }

        $fecha = $data['data']['fecha_gasto'];
        $periodo = date('Y-m', strtotime($fecha));
        [$anio, $mes] = explode('-', $periodo);

        $cierreModel = new \App\Models\CierreModel();
        $cierre = $cierreModel
            ->where('usuario_id', $data['data']['usuario_id'])
            ->where('anio', (int) $anio)
            ->where('mes', (int) $mes)
            ->first();

        if ($cierre) {
            throw new \RuntimeException("No se puede modificar gastos de un período cerrado ({$periodo}).");
        }

        // Asignar período automáticamente.
        $data['data']['periodo'] = $periodo;

        return $data;
    }

    /**
     * Obtener todos los gastos de un usuario con información de categoría
     */
    public function getGastosPorUsuario($usuarioId)
    {
        return $this->select('gastos.*, categorias.nombre as categoria_nombre')
                    ->join('categorias', 'categorias.id = gastos.categoria_id', 'left')
                    ->where('gastos.usuario_id', $usuarioId)
                    ->orderBy('gastos.fecha_gasto', 'DESC')
                    ->findAll();
    }

    /**
     * Calcular total de gastos de un usuario
     */
    public function getTotalGastos($usuarioId)
    {
        $result = $this->selectSum('monto')
                       ->where('usuario_id', $usuarioId)
                       ->first();
        
        return $result['monto'] ?? 0;
    }

    /**
     * Obtener gastos agrupados por mes
     */
    public function getGastosPorMes($usuarioId, $limite = 6)
    {
        return $this->select('YEAR(fecha_gasto) as anio, MONTH(fecha_gasto) as mes, SUM(monto) as total')
                    ->where('usuario_id', $usuarioId)
                    ->groupBy('YEAR(fecha_gasto), MONTH(fecha_gasto)')
                    ->orderBy('YEAR(fecha_gasto) DESC, MONTH(fecha_gasto) DESC')
                    ->limit($limite)
                    ->findAll();
    }

    /**
     * Obtener gastos agrupados por categoría
     */
    public function getGastosPorCategoria($usuarioId)
    {
        return $this->select('categorias.nombre as categoria, SUM(gastos.monto) as total')
                    ->join('categorias', 'categorias.id = gastos.categoria_id', 'left')
                    ->where('gastos.usuario_id', $usuarioId)
                    ->groupBy('gastos.categoria_id')
                    ->orderBy('total', 'DESC')
                    ->findAll();
    }

    /**
     * Obtener gastos por rango de fechas
     */
    public function getGastosPorFechas($usuarioId, $fechaInicio, $fechaFin)
    {
        return $this->where('usuario_id', $usuarioId)
                    ->where('fecha_gasto >=', $fechaInicio)
                    ->where('fecha_gasto <=', $fechaFin)
                    ->orderBy('fecha_gasto', 'DESC')
                    ->findAll();
    }
}
