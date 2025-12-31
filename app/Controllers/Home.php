<?php

namespace App\Controllers;

use App\Models\CategoriaModel;

class Home extends BaseController
{
    public function index(): string
    {
        $categoriaModel = new CategoriaModel();
        $categorias = $categoriaModel->findAll();

        return view('dashboard', ['categorias' => $categorias]);
    }

    public function guardarGasto()
    {
        $model = new \App\Models\GastoModel();

        $data = [
            'usuario_id'   => 1, // Usuario de prueba
            'categoria_id' => $this->request->getPost('categoria_id'),
            'monto'        => $this->request->getPost('monto'),
            'descripcion'  => $this->request->getPost('descripcion'),
            'fecha_gasto'  => $this->request->getPost('fecha_gasto'),
        ];

        $model->insert($data);

        return redirect()->to(base_url('/'))->with('mensaje', 'Gasto guardado con éxito');
    }
}
