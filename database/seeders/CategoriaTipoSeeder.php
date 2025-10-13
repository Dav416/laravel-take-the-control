<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoriaTipo;

class CategoriaTipoSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            [
                'nombre_categoria_tipo' => 'Ingreso',
                'descripcion_categoria_tipo' => 'Representa entradas de dinero.',
            ],
            [
                'nombre_categoria_tipo' => 'Egreso',
                'descripcion_categoria_tipo' => 'Representa salidas de dinero.',
            ],
        ];

        foreach ($categorias as $categoria) {
            CategoriaTipo::create($categoria);
        }
    }
}
