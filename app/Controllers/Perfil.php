<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsuarioModel;
use App\Models\IngresoModel;
use App\Models\CategoriaModel;

class Perfil extends BaseController
{
    protected $usuarioModel;
    protected $ingresoModel;
    protected $categoriaModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->ingresoModel = new IngresoModel();
        $this->categoriaModel = new CategoriaModel();
    }

    /**
     * Mostrar el perfil del usuario con sus ingresos
     */
    public function index()
    {
        // Verificar si el usuario está logueado
        if (!session()->get('logueado')) {
            return redirect()->to(base_url('auth'));
        }

        $usuarioId = session()->get('usuario_id');
        
        // Obtener información del usuario
        $usuario = $this->usuarioModel->find($usuarioId);
        
        // Obtener ingresos del usuario
        $ingresos = $this->ingresoModel->getIngresosPorUsuario($usuarioId);
        
        // Calcular totales
        $totalOrdinarios = $this->ingresoModel->getTotalPorTipo($usuarioId, 'ordinario');
        $totalExtraordinarios = $this->ingresoModel->getTotalPorTipo($usuarioId, 'extraordinario');
        $totalIngresos = $this->ingresoModel->getTotalIngresos($usuarioId);
        
        $data = [
            'usuario' => $usuario,
            'ingresos' => $ingresos,
            'totalOrdinarios' => $totalOrdinarios,
            'totalExtraordinarios' => $totalExtraordinarios,
            'totalIngresos' => $totalIngresos,
            'categorias' => $this->categoriaModel->findAll()
        ];

        return view('perfil/index', $data);
    }

    /**
     * Actualizar información del usuario
     */
    public function actualizar()
    {
        if (!session()->get('logueado')) {
            return redirect()->to(base_url('auth'));
        }

        $usuarioId = session()->get('usuario_id');
        
        $datos = [
            'nombre' => $this->request->getPost('nombre'),
            'email' => $this->request->getPost('email')
        ];

        // Si se proporcionó una nueva contraseña, actualizarla
        $nuevaPassword = $this->request->getPost('password');
        if (!empty($nuevaPassword)) {
            $datos['password'] = password_hash($nuevaPassword, PASSWORD_DEFAULT);
        }

        if ($this->usuarioModel->update($usuarioId, $datos)) {
            // Actualizar la sesión
            session()->set([
                'usuario_nombre' => $datos['nombre'],
                'usuario_email' => $datos['email']
            ]);
            
            session()->setFlashdata('success', 'Perfil actualizado correctamente.');
        } else {
            session()->setFlashdata('error', 'Error al actualizar el perfil.');
        }

        return redirect()->to(base_url('perfil'));
    }

    /**
     * Mostrar formulario para agregar ingreso
     */
    public function nuevoIngreso()
    {
        if (!session()->get('logueado')) {
            return redirect()->to(base_url('auth'));
        }

        return view('perfil/nuevo_ingreso');
    }

    /**
     * Guardar nuevo ingreso
     */
    public function guardarIngreso()
    {
        if (!session()->get('logueado')) {
            return redirect()->to(base_url('auth'));
        }

        $usuarioId = session()->get('usuario_id');

        $datos = [
            'usuario_id' => $usuarioId,
            'monto' => $this->request->getPost('monto'),
            'tipo' => $this->request->getPost('tipo'),
            'descripcion' => $this->request->getPost('descripcion'),
            'fecha_ingreso' => $this->request->getPost('fecha_ingreso'),
            'es_recurrente' => $this->request->getPost('es_recurrente') ? true : false
        ];

        if ($this->ingresoModel->insert($datos)) {
            session()->setFlashdata('success', 'Ingreso registrado correctamente.');
        } else {
            session()->setFlashdata('error', 'Error al registrar el ingreso.');
        }

        return redirect()->to(base_url('perfil'));
    }

    /**
     * Editar ingreso existente
     */
    public function editarIngreso($id)
    {
        if (!session()->get('logueado')) {
            return redirect()->to(base_url('auth'));
        }

        $usuarioId = session()->get('usuario_id');
        $ingreso = $this->ingresoModel->find($id);

        // Verificar que el ingreso pertenece al usuario
        if (!$ingreso || $ingreso['usuario_id'] != $usuarioId) {
            session()->setFlashdata('error', 'Ingreso no encontrado.');
            return redirect()->to(base_url('perfil'));
        }

        return view('perfil/editar_ingreso', ['ingreso' => $ingreso]);
    }

    /**
     * Actualizar ingreso
     */
    public function actualizarIngreso($id)
    {
        if (!session()->get('logueado')) {
            return redirect()->to(base_url('auth'));
        }

        $usuarioId = session()->get('usuario_id');
        $ingreso = $this->ingresoModel->find($id);

        // Verificar que el ingreso pertenece al usuario
        if (!$ingreso || $ingreso['usuario_id'] != $usuarioId) {
            session()->setFlashdata('error', 'Ingreso no encontrado.');
            return redirect()->to(base_url('perfil'));
        }

        $datos = [
            'monto' => $this->request->getPost('monto'),
            'tipo' => $this->request->getPost('tipo'),
            'descripcion' => $this->request->getPost('descripcion'),
            'fecha_ingreso' => $this->request->getPost('fecha_ingreso'),
            'es_recurrente' => $this->request->getPost('es_recurrente') ? true : false
        ];

        if ($this->ingresoModel->update($id, $datos)) {
            session()->setFlashdata('success', 'Ingreso actualizado correctamente.');
        } else {
            session()->setFlashdata('error', 'Error al actualizar el ingreso.');
        }

        return redirect()->to(base_url('perfil'));
    }

    /**
     * Eliminar ingreso
     */
    public function eliminarIngreso($id)
    {
        if (!session()->get('logueado')) {
            return redirect()->to(base_url('auth'));
        }

        $usuarioId = session()->get('usuario_id');
        $ingreso = $this->ingresoModel->find($id);

        // Verificar que el ingreso pertenece al usuario
        if (!$ingreso || $ingreso['usuario_id'] != $usuarioId) {
            session()->setFlashdata('error', 'Ingreso no encontrado.');
            return redirect()->to(base_url('perfil'));
        }

        if ($this->ingresoModel->delete($id)) {
            session()->setFlashdata('success', 'Ingreso eliminado correctamente.');
        } else {
            session()->setFlashdata('error', 'Error al eliminar el ingreso.');
        }

        return redirect()->to(base_url('perfil'));
    }
}
