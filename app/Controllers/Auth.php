<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
    public function index()
    {
        return view('auth/login');
    }

   //Intentar login
   public function intentarLogin()
   {
         $model = new \App\Models\UsuarioModel();
    
         $email = $this->request->getPost('email');
         $password = $this->request->getPost('password');
    
         $usuario = $model->where('email', $email)->first();
    
         if ($usuario && password_verify($password, $usuario['password'])) {
              // Credenciales válidas, iniciar sesión
              session()->set([
                  'usuario_id' => $usuario['id'],
                  'usuario_nombre' => $usuario['nombre'],
                  'usuario_email' => $usuario['email'],
                  'logueado' => true
              ]);
              return redirect()->to(base_url('home'));
         } else {
              // Credenciales inválidas, mostrar error
              session()->setFlashdata('error', 'Correo electrónico o contraseña incorrectos.');
              return redirect()->back();
         }
   }

    public function registro()
    {
     return view('auth/registro');
    }

    public function intentarRegistrar() {
    $model = new \App\Models\UsuarioModel();

    $passwordPlana = $this->request->getPost('password');
    
    $data = [
        'nombre'   => $this->request->getPost('nombre'),
        'email'    => $this->request->getPost('email'),
        // Encriptar la contraseña por seguridad
        'password' => password_hash($passwordPlana, PASSWORD_DEFAULT) 
    ];

    $model->insert($data);

    return redirect()->to(base_url(''))->with('success', '¡Usuario creado exitosamente! Ya puedes iniciar sesión.');
}

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url(''))->with('success', 'Sesión cerrada correctamente.');
    }

}
