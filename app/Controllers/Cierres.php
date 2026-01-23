<?php

namespace App\Controllers;

use App\Models\CierreModel;
use App\Models\CategoriaModel;

class Cierres extends BaseController
{
    /**
     * Muestra el historial de cierres de mes del usuario.
     */
    public function index()
    {
        if (!session()->has('usuario_id')) {
            return redirect()->to(base_url('login'))->with('error', 'Debes iniciar sesión primero.');
        }

        $cierreModel = new CierreModel();
        $categoriaModel = new CategoriaModel();
        $cierres = $cierreModel
            ->where('usuario_id', session()->get('usuario_id'))
            ->orderBy('anio DESC, mes DESC')
            ->findAll();

        $usuario = [
            'id' => session()->get('usuario_id'),
            'nombre' => session()->get('usuario_nombre'),
            'email' => session()->get('usuario_email')
        ];

        return view('cierres/index', [
            'cierres' => $cierres,
            'usuario' => $usuario,
            'categorias' => $categoriaModel->findAll()
        ]);
    }

    /**
     * Muestra el detalle de un cierre específico.
     */
    public function ver($id)
    {
        if (!session()->has('usuario_id')) {
            return redirect()->to(base_url('login'))->with('error', 'Debes iniciar sesión primero.');
        }

        $cierreModel = new CierreModel();
        $cierre = $cierreModel->find($id);

        if (!$cierre || $cierre['usuario_id'] != session()->get('usuario_id')) {
            return redirect()->to(base_url('cierres'))->with('error', 'Cierre no encontrado.');
        }

        // Obtener detalles de ingresos y gastos del período.
        $ingresoModel = new \App\Models\IngresoModel();
        $gastoModel = new \App\Models\GastoModel();

        $periodo = sprintf('%04d-%02d', $cierre['anio'], $cierre['mes']);
        
        $ingresos = $ingresoModel
            ->where('usuario_id', session()->get('usuario_id'))
            ->where('periodo', $periodo)
            ->orderBy('fecha_ingreso', 'DESC')
            ->findAll();

        $gastos = $gastoModel
            ->select('gastos.*, categorias.nombre as categoria_nombre')
            ->join('categorias', 'categorias.id = gastos.categoria_id', 'left')
            ->where('gastos.usuario_id', session()->get('usuario_id'))
            ->where('gastos.periodo', $periodo)
            ->orderBy('gastos.fecha_gasto', 'DESC')
            ->findAll();

        $categoriaModel = new CategoriaModel();
        $usuario = [
            'id' => session()->get('usuario_id'),
            'nombre' => session()->get('usuario_nombre'),
            'email' => session()->get('usuario_email')
        ];

        return view('cierres/detalle', [
            'cierre' => $cierre,
            'ingresos' => $ingresos,
            'gastos' => $gastos,
            'usuario' => $usuario,
            'categorias' => $categoriaModel->findAll()
        ]);
    }
}
