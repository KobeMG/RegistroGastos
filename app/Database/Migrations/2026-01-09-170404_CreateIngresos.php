<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIngresos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'usuario_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'monto' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'tipo' => [
                'type'       => 'ENUM',
                'constraint' => ['ordinario', 'extraordinario'],
                'default'    => 'ordinario',
            ],
            'descripcion' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'fecha_ingreso' => [
                'type' => 'DATE',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('usuario_id', 'usuarios', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('ingresos');
    }

    public function down()
    {
        $this->forge->dropTable('ingresos');
    }
}
