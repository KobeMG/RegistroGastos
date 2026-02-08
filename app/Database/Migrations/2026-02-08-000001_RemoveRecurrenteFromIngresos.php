<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveRecurrenteFromIngresos extends Migration
{
    public function up()
    {
        // Eliminar la columna es_recurrente que es redundante
        // Los ingresos ordinarios se copiarán automáticamente en el cierre de mes
        $this->forge->dropColumn('ingresos', 'es_recurrente');
    }

    public function down()
    {
        // Restaurar la columna en caso de rollback
        $this->forge->addColumn('ingresos', [
            'es_recurrente' => [
                'type'       => 'BOOLEAN',
                'default'    => false,
                'null'       => false,
                'after'      => 'tipo'
            ]
        ]);
    }
}
