<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoriaTransaccion;

class CategoriaTransaccionSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            // Ingresos
            [
                'nombre_categoria_transaccion' => 'Salario',
                'descripcion_categoria_transaccion' => 'Ingresos por trabajo dependiente',
            ],
            [
                'nombre_categoria_transaccion' => 'Negocio',
                'descripcion_categoria_transaccion' => 'Ingresos por actividad empresarial o independiente',
            ],
            [
                'nombre_categoria_transaccion' => 'Inversiones',
                'descripcion_categoria_transaccion' => 'Dividendos, intereses y ganancias de capital',
            ],

            // Gastos fijos
            [
                'nombre_categoria_transaccion' => 'Vivienda',
                'descripcion_categoria_transaccion' => 'Alquiler, hipoteca, servicios públicos',
            ],
            [
                'nombre_categoria_transaccion' => 'Transporte',
                'descripcion_categoria_transaccion' => 'Combustible, mantenimiento, transporte público',
            ],
            [
                'nombre_categoria_transaccion' => 'Alimentación',
                'descripcion_categoria_transaccion' => 'Supermercado, restaurantes, comidas',
            ],

            // Gastos variables
            [
                'nombre_categoria_transaccion' => 'Entretenimiento',
                'descripcion_categoria_transaccion' => 'Ocio, cine, streaming, eventos',
            ],
            [
                'nombre_categoria_transaccion' => 'Salud',
                'descripcion_categoria_transaccion' => 'Seguros, medicinas, consultas médicas',
            ],
            [
                'nombre_categoria_transaccion' => 'Educación',
                'descripcion_categoria_transaccion' => 'Matrículas, cursos, libros, material educativo',
            ],
            [
                'nombre_categoria_transaccion' => 'Ropa',
                'descripcion_categoria_transaccion' => 'Vestimenta y calzado',
            ],
            [
                'nombre_categoria_transaccion' => 'Otros',
                'descripcion_categoria_transaccion' => 'Gastos varios no categorizados',
            ],
        ];

        foreach ($categorias as $categoria) {
            CategoriaTransaccion::create($categoria);
        }
    }
}
