<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\IngresoModel;

class Ingresos extends BaseController
{
    protected $ingresoModel;

    public function __construct()
    {
        $this->ingresoModel = new IngresoModel();
    }

    /**
     * Mostrar listado de ingresos
     */
    public function index()
    {
        if (!session()->has('usuario_id')) {
            return redirect()->to(base_url('login'));
        }

        $usuarioId = session()->get('usuario_id');
        $ingresos = $this->ingresoModel->getIngresosPorUsuario($usuarioId);

        $usuario = [
            'id' => session()->get('usuario_id'),
            'nombre' => session()->get('usuario_nombre'),
            'email' => session()->get('usuario_email')
        ];

        return view('ingresos/index', [
            'ingresos' => $ingresos,
            'usuario' => $usuario
        ]);
    }

    /**
     * Guardar nuevo ingreso
     */
    public function guardar()
    {
        if (!session()->has('usuario_id')) {
            return redirect()->to(base_url('login'));
        }

        $usuarioId = session()->get('usuario_id');

        $datos = [
            'usuario_id' => $usuarioId,
            'monto' => $this->request->getPost('monto'),
            'tipo' => $this->request->getPost('tipo'),
            'descripcion' => $this->request->getPost('descripcion'),
            'fecha_ingreso' => $this->request->getPost('fecha_ingreso')
        ];

        if ($this->ingresoModel->insert($datos)) {
            return redirect()->to(base_url('ingresos'))->with('success', 'Ingreso registrado correctamente');
        } else {
            return redirect()->to(base_url('ingresos'))->with('error', 'Error al registrar el ingreso');
        }
    }

    /**
     * Actualizar ingreso existente
     */
    public function actualizar($id)
    {
        if (!session()->has('usuario_id')) {
            return redirect()->to(base_url('login'));
        }

        $usuarioId = session()->get('usuario_id');
        $ingreso = $this->ingresoModel->find($id);

        // Verificar que el ingreso pertenece al usuario logueado
        if (!$ingreso || $ingreso['usuario_id'] != $usuarioId) {
            return redirect()->to(base_url('ingresos'))->with('error', 'No tienes permiso para actualizar este ingreso');
        }

        $datos = [
            'monto' => $this->request->getPost('monto'),
            'tipo' => $this->request->getPost('tipo'),
            'descripcion' => $this->request->getPost('descripcion'),
            'fecha_ingreso' => $this->request->getPost('fecha_ingreso')
        ];

        if ($this->ingresoModel->update($id, $datos)) {
            return redirect()->to(base_url('ingresos'))->with('success', 'Ingreso actualizado correctamente');
        } else {
            return redirect()->to(base_url('ingresos'))->with('error', 'Error al actualizar el ingreso');
        }
    }

    /**
     * Eliminar ingreso
     */
    public function eliminar($id)
    {
        if (!session()->has('usuario_id')) {
            return redirect()->to(base_url('login'));
        }

        $usuarioId = session()->get('usuario_id');
        $ingreso = $this->ingresoModel->find($id);

        // Verificar que el ingreso pertenece al usuario logueado
        if (!$ingreso || $ingreso['usuario_id'] != $usuarioId) {
            return redirect()->to(base_url('ingresos'))->with('error', 'No tienes permiso para eliminar este ingreso');
        }

        if ($this->ingresoModel->delete($id)) {
            return redirect()->to(base_url('ingresos'))->with('success', 'Ingreso eliminado correctamente');
        } else {
            return redirect()->to(base_url('ingresos'))->with('error', 'Error al eliminar el ingreso');
        }
    }
}
