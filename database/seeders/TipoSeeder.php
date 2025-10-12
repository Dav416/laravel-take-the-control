<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tipo;

class TipoSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            [
                'nombre_tipo' => 'Ingreso',
                'descripcion_tipo' => 'Transacciones que representan entradas de dinero',
                'categoria_tipo_id' => 1,
            ],
            [
                'nombre_tipo' => 'Egreso',
                'descripcion_tipo' => 'Transacciones que representan salidas de dinero',
                'categoria_tipo_id' => 2,
            ],
        ];

        foreach ($tipos as $tipo) {
            Tipo::create($tipo);
        }
    }
}
