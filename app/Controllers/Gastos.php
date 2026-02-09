<?php

namespace App\Controllers;

use App\Models\CategoriaModel;
use App\Models\GastoModel;

class Gastos extends BaseController
{
    /**
     * Mostrar listado de gastos
     */
    public function index()
    {
        if (!session()->has('usuario_id')) {
            return redirect()->to(base_url('login'));
        }

        $categoriaModel = new CategoriaModel();
        $gastoModel = new GastoModel();
        
        $categorias = $categoriaModel->findAll();
        $gastos = $gastoModel->getGastosPorUsuario(session()->get('usuario_id'));
        
        $usuario = [
            'id' => session()->get('usuario_id'),
            'nombre' => session()->get('usuario_nombre'),
            'email' => session()->get('usuario_email')
        ];

        return view('gastos/index', [
            'categorias' => $categorias,
            'gastos' => $gastos,
            'usuario' => $usuario
        ]);
    }

    /**
     * Guardar nuevo gasto
     */
    public function guardar()
    {
        if (!session()->has('usuario_id')) {
            return redirect()->to(base_url('login'));
        }

        $gastoModel = new GastoModel();

        $data = [
            'usuario_id'   => session()->get('usuario_id'),
            'categoria_id' => $this->request->getPost('categoria_id'),
            'monto'        => $this->request->getPost('monto'),
            'descripcion'  => $this->request->getPost('descripcion'),
            'fecha_gasto'  => $this->request->getPost('fecha_gasto'),
        ];

        $gastoModel->insert($data);

        return redirect()->to(base_url('gastos'))->with('success', 'Gasto guardado con éxito');
    }

    /**
     * Actualizar gasto existente
     */
    public function actualizar($id)
    {
        if (!session()->has('usuario_id')) {
            return redirect()->to(base_url('login'));
        }

        $gastoModel = new GastoModel();
        
        // Verificar que el gasto pertenece al usuario logueado
        $gasto = $gastoModel->find($id);
        
        if (!$gasto || $gasto['usuario_id'] != session()->get('usuario_id')) {
            return redirect()->to(base_url('gastos'))->with('error', 'No tienes permiso para actualizar este gasto');
        }
        
        $data = [
            'categoria_id' => $this->request->getPost('categoria_id'),
            'monto'        => $this->request->getPost('monto'),
            'descripcion'  => $this->request->getPost('descripcion'),
            'fecha_gasto'  => $this->request->getPost('fecha_gasto'),
        ];
        
        $gastoModel->update($id, $data);
        
        return redirect()->to(base_url('gastos'))->with('success', 'Gasto actualizado con éxito');
    }

    /**
     * Eliminar gasto
     */
    public function eliminar($id)
    {
        if (!session()->has('usuario_id')) {
            return redirect()->to(base_url('login'));
        }

        $gastoModel = new GastoModel();
        
        // Verificar que el gasto pertenece al usuario logueado
        $gasto = $gastoModel->find($id);
        
        if ($gasto && $gasto['usuario_id'] == session()->get('usuario_id')) {
            $gastoModel->delete($id);
            return redirect()->to(base_url('gastos'))->with('success', 'Gasto eliminado con éxito');
        }
        
        return redirect()->to(base_url('gastos'))->with('error', 'No tienes permiso para eliminar este gasto');
    }
}
