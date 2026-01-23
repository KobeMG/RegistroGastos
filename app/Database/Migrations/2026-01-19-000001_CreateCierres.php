<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCierres extends Migration
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
            'anio' => [
                'type'       => 'SMALLINT',
                'constraint' => 4,
                'unsigned'   => true,
            ],
            'mes' => [
                'type'       => 'TINYINT',
                'constraint' => 2,
                'unsigned'   => true,
            ],
            'total_ingresos' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => '0.00',
            ],
            'total_gastos' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => '0.00',
            ],
            'balance' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => '0.00',
            ],
            'generado_en' => [
                'type' => 'DATETIME',
                'null' => false,
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
        // Índice único para evitar duplicar cierres por usuario/mes sin convertirlo en primary.
        $this->forge->addKey(['usuario_id', 'anio', 'mes'], false, true);
        $this->forge->addForeignKey('usuario_id', 'usuarios', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('cierres');
    }

    public function down()
    {
        $this->forge->dropTable('cierres');
    }
}
