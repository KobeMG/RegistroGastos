<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPeriodoToGastos extends Migration
{
    public function up()
    {
        $this->forge->addColumn('gastos', [
            'periodo' => [
                'type'       => 'VARCHAR',
                'constraint' => 7,
                'null'       => true,
                'comment'    => 'Formato YYYY-MM para identificar el período',
                'after'      => 'fecha_gasto'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('gastos', 'periodo');
    }
}
