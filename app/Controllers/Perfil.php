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
     * Generar token API para el usuario
     */
    public function generarToken()
    {
        if (!session()->get('logueado')) {
            return redirect()->to(base_url('auth'));
        }

        $usuarioId = session()->get('usuario_id');
        $token = $this->usuarioModel->generarApiToken($usuarioId);

        if ($token) {
            session()->setFlashdata('success', 'Token API generado correctamente.');
            session()->setFlashdata('api_token', $token);
        } else {
            session()->setFlashdata('error', 'Error al generar el token API.');
        }

        return redirect()->to(base_url('perfil'));
    }

    /**
     * Revocar token API del usuario
     */
    public function revocarToken()
    {
        if (!session()->get('logueado')) {
            return redirect()->to(base_url('auth'));
        }

        $usuarioId = session()->get('usuario_id');
        
        if ($this->usuarioModel->revocarApiToken($usuarioId)) {
            session()->setFlashdata('success', 'Token API revocado correctamente.');
        } else {
            session()->setFlashdata('error', 'Error al revocar el token API.');
        }

        return redirect()->to(base_url('perfil'));
    }
}
