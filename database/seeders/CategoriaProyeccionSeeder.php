<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoriaProyeccion;

class CategoriaProyeccionSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            [
                'nombre_categoria_proyeccion' => 'Ahorro',
                'descripcion_categoria_proyeccion' => 'Proyecciones relacionadas con metas de ahorro personal o empresarial',
            ],
            [
                'nombre_categoria_proyeccion' => 'Inversión',
                'descripcion_categoria_proyeccion' => 'Proyecciones para inversiones a corto, mediano y largo plazo',
            ],
            [
                'nombre_categoria_proyeccion' => 'Deuda',
                'descripcion_categoria_proyeccion' => 'Proyecciones para el pago de deudas y préstamos',
            ],
            [
                'nombre_categoria_proyeccion' => 'Emergencias',
                'descripcion_categoria_proyeccion' => 'Fondo de emergencia y gastos imprevistos',
            ],
            [
                'nombre_categoria_proyeccion' => 'Retiro',
                'descripcion_categoria_proyeccion' => 'Proyecciones para jubilación y pensión',
            ],
            [
                'nombre_categoria_proyeccion' => 'Educación',
                'descripcion_categoria_proyeccion' => 'Ahorro para educación propia o de dependientes',
            ],
        ];

        foreach ($categorias as $categoria) {
            CategoriaProyeccion::create($categoria);
        }
    }
}
