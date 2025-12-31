<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nombre' => 'Alimentación',
                'color'  => '#FF5733', // Naranja/Rojo
            ],
            [
                'nombre' => 'Transporte',
                'color'  => '#3357FF', // Azul
            ],
            [
                'nombre' => 'Vivienda',
                'color'  => '#33FF57', // Verde
            ],
            [
                'nombre' => 'Entretenimiento',
                'color'  => '#F333FF', // Morado
            ],
            [
                'nombre' => 'Salud',
                'color'  => '#FF3333', // Rojo fuerte
            ],
            [
                'nombre' => 'Otros',
                'color'  => '#808080', // Gris
            ],
        ];

        // Insertar los datos en la tabla 'categorias'
        $this->db->table('categorias')->insertBatch($data);
    }
}