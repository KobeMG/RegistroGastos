<?php

namespace App\Controllers\Api;

use App\Controllers\ApiBaseController;
use App\Models\UsuarioModel;
use App\Models\GastoModel;
use App\Models\CategoriaModel;
use CodeIgniter\HTTP\ResponseInterface;

class Gastos extends ApiBaseController
{
    /**
     * Registrar un gasto mediante API
     * 
     * Endpoint: POST /api/gastos/registrar
     * 
     * Headers:
     *   Authorization: Bearer {api_token}
     *   Content-Type: application/json
     * 
     * Body:
     * {
     *   "categoria_id": 1,
     *   "monto": 15000.50,
     *   "descripcion": "Compra en supermercado",
     *   "fecha_gasto": "2026-02-08"
     * }
     */
    public function registrar()
    {
        // Validar que sea POST
        if (!$this->request->is('post')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Método no permitido'
            ])->setStatusCode(405);
        }

        // Obtener y validar el token
        $authHeader = $this->request->getHeaderLine('Authorization');
        $token = str_replace('Bearer ', '', $authHeader);

        if (empty($token)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Token de autorización requerido'
            ])->setStatusCode(401);
        }

        // Buscar usuario por token
        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->findByApiToken($token);

        if (!$usuario) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Token inválido o usuario no encontrado'
            ])->setStatusCode(401);
        }

        // Obtener datos del request
        $json = $this->request->getJSON(true);
        
        // Validar datos requeridos
        $errores = [];
        
        if (empty($json['categoria_id'])) {
            $errores[] = 'categoria_id es requerido';
        }
        
        if (empty($json['monto']) || $json['monto'] <= 0) {
            $errores[] = 'monto debe ser mayor a 0';
        }
        
        if (empty($json['fecha_gasto'])) {
            $json['fecha_gasto'] = date('Y-m-d'); // Por defecto hoy
        }

        if (!empty($errores)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Errores de validación',
                'errors' => $errores
            ])->setStatusCode(400);
        }

        // Validar que la categoría existe
        $categoriaModel = new CategoriaModel();
        $categoria = $categoriaModel->find($json['categoria_id']);
        
        if (!$categoria) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Categoría no encontrada'
            ])->setStatusCode(404);
        }

        // Preparar datos del gasto
        $data = [
            'usuario_id'   => $usuario['id'],
            'categoria_id' => $json['categoria_id'],
            'monto'        => $json['monto'],
            'descripcion'  => $json['descripcion'] ?? 'Gasto registrado via API',
            'fecha_gasto'  => $json['fecha_gasto'],
        ];

        // Guardar gasto
        $gastoModel = new GastoModel();
        $gastoId = $gastoModel->insert($data);

        if (!$gastoId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error al guardar el gasto',
                'errors' => $gastoModel->errors()
            ])->setStatusCode(500);
        }

        // Respuesta exitosa
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Gasto registrado exitosamente',
            'data' => [
                'id' => $gastoId,
                'usuario' => $usuario['nombre'],
                'categoria' => $categoria['nombre'],
                'monto' => $json['monto'],
                'fecha_gasto' => $json['fecha_gasto']
            ]
        ])->setStatusCode(201);
    }
}
