<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGastos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'usuario_id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'categoria_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'monto'        => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'descripcion'  => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true],
            'fecha_gasto'  => ['type' => 'DATE'],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        // Relaciones (Foreign Keys)
        $this->forge->addForeignKey('usuario_id', 'usuarios', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('categoria_id', 'categorias', 'id', 'CASCADE', 'RESTRICT');

        $this->forge->createTable('gastos');
    }

    public function down()
    {
        $this->forge->dropTable('gastos');
    }
}
