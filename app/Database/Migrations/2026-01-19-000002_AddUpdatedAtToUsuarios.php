<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUpdatedAtToUsuarios extends Migration
{
    public function up()
    {
        $this->forge->addColumn('usuarios', [
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'created_at'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('usuarios', 'updated_at');
    }
}
