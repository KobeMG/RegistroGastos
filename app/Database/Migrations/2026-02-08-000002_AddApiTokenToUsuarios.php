<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddApiTokenToUsuarios extends Migration
{
    public function up()
    {
        $this->forge->addColumn('usuarios', [
            'api_token' => [
                'type'       => 'VARCHAR',
                'constraint' => 64,
                'null'       => true,
                'unique'     => true,
                'comment'    => 'Token de autenticación para API (opcional)',
                'after'      => 'password'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('usuarios', 'api_token');
    }
}
