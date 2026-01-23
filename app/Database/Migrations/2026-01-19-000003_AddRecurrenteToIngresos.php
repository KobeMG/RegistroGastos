<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRecurrenteToIngresos extends Migration
{
    public function up()
    {
        $this->forge->addColumn('ingresos', [
            'es_recurrente' => [
                'type'       => 'BOOLEAN',
                'default'    => false,
                'null'       => false,
                'after'      => 'tipo'
            ],
            'periodo' => [
                'type'       => 'VARCHAR',
                'constraint' => 7,
                'null'       => true,
                'comment'    => 'Formato YYYY-MM para identificar el período',
                'after'      => 'es_recurrente'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('ingresos', ['es_recurrente', 'periodo']);
    }
}
