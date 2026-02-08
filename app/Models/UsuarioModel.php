<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table            = 'usuarios';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nombre', 'email', 'password', 'api_token'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
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
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Genera un token API único para el usuario
     */
    public function generarApiToken(int $usuarioId): ?string
    {
        $token = bin2hex(random_bytes(32)); // 64 caracteres
        
        $updated = $this->update($usuarioId, ['api_token' => $token]);
        
        return $updated ? $token : null;
    }

    /**
     * Busca un usuario por su API token
     */
    public function findByApiToken(string $token): ?array
    {
        return $this->where('api_token', $token)->first();
    }

    /**
     * Revoca el token API del usuario
     */
    public function revocarApiToken(int $usuarioId): bool
    {
        return $this->update($usuarioId, ['api_token' => null]);
    }
}
