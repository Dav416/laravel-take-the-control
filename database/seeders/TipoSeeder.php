<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tipo;
use App\Models\CategoriaTipo;

class TipoSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener categorías de tipos
        $categoriaIngreso = CategoriaTipo::where('nombre_categoria_tipo', 'Ingreso')->first();
        $categoriaEgreso = CategoriaTipo::where('nombre_categoria_tipo', 'Egreso')->first();

        if (!$categoriaIngreso || !$categoriaEgreso) {
            $this->command->warn('Asegúrate de ejecutar CategoriaTipoSeeder primero');
            return;
        }

        $tipos = [
            [
                'nombre_tipo' => 'Ingreso',
                'descripcion_tipo' => 'Transacciones que representan entradas de dinero',
                'categoria_tipo_id' => $categoriaIngreso->id_categoria_tipo,
            ],
            [
                'nombre_tipo' => 'Egreso',
                'descripcion_tipo' => 'Transacciones que representan salidas de dinero',
                'categoria_tipo_id' => $categoriaEgreso->id_categoria_tipo,
            ],
        ];

        foreach ($tipos as $tipo) {
            Tipo::create($tipo);
        }
    }
}
