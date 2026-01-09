<?php

namespace App\Controllers;

use App\Models\CategoriaModel;
use App\Models\GastoModel;

class Home extends BaseController
{
    //Se esta usando Home como el controlador base del Dashboard
    public function index(): string
    {
        $categoriaModel = new CategoriaModel();
        $categorias = $categoriaModel->findAll(); // Buscar todas las categorias que tengo en la BD

        // Obtener los gastos del usuario actual
        $gastos = [];
        $usuario = null;
        
        if (session()->has('usuario_id')) {
            $gastoModel = new GastoModel();
            $gastos = $gastoModel->getGastosPorUsuario(session()->get('usuario_id'));
            
            // Información del usuario de la sesión
            $usuario = [
                'id' => session()->get('usuario_id'),
                'nombre' => session()->get('usuario_nombre'),
                'email' => session()->get('usuario_email')
            ];
        }

        return view('dashboard', [
            'categorias' => $categorias,
            'gastos' => $gastos,
            'usuario' => $usuario
        ]);
    }

    public function guardarGasto()
    {
        $model = new \App\Models\GastoModel();

        $data = [
            'usuario_id'   => session()->get('usuario_id'),
            'categoria_id' => $this->request->getPost('categoria_id'),
            'monto'        => $this->request->getPost('monto'),
            'descripcion'  => $this->request->getPost('descripcion'),
            'fecha_gasto'  => $this->request->getPost('fecha_gasto'),
        ];

        $model->insert($data);

        return redirect()->to(base_url('home'))->with('success', 'Gasto guardado con éxito');
    }

    public function eliminarGasto($id)
    {
        $gastoModel = new GastoModel();
        
        // Verificar que el gasto pertenece al usuario logueado
        $gasto = $gastoModel->find($id);
        
        if ($gasto && $gasto['usuario_id'] == session()->get('usuario_id')) {
            $gastoModel->delete($id);
            return redirect()->to(base_url('home'))->with('success', 'Gasto eliminado con éxito');
        }
        
        return redirect()->to(base_url('home'))->with('error', 'No tienes permiso para eliminar este gasto');
    }
    public function editarGasto($id)
    {
        $gastoModel = new GastoModel();
        
        // Verificar que el gasto pertenece al usuario logueado
        $gasto = $gastoModel->find($id);
        
        if (!$gasto || $gasto['usuario_id'] != session()->get('usuario_id')) {
            return redirect()->to(base_url('home'))->with('error', 'No tienes permiso para editar este gasto');
        }
        
        $categoriaModel = new CategoriaModel();
        $categorias = $categoriaModel->findAll();
        
        $usuario = [
            'id' => session()->get('usuario_id'),
            'nombre' => session()->get('usuario_nombre'),
            'email' => session()->get('usuario_email')
        ];
        
        return view('dashboard', [
            'categorias' => $categorias,
            'gasto_editar' => $gasto,
            'usuario' => $usuario
        ]);
    }

    public function actualizarGasto($id)
    {
        $gastoModel = new GastoModel();
        
        // Verificar que el gasto pertenece al usuario logueado
        $gasto = $gastoModel->find($id);
        
        if (!$gasto || $gasto['usuario_id'] != session()->get('usuario_id')) {
            return redirect()->to(base_url('home'))->with('error', 'No tienes permiso para actualizar este gasto');
        }
        
        $data = [
            'categoria_id' => $this->request->getPost('categoria_id'),
            'monto'        => $this->request->getPost('monto'),
            'descripcion'  => $this->request->getPost('descripcion'),
            'fecha_gasto'  => $this->request->getPost('fecha_gasto'),
        ];
        
        $gastoModel->update($id, $data);
        
        return redirect()->to(base_url('home'))->with('success', 'Gasto actualizado con éxito');
    }
}
