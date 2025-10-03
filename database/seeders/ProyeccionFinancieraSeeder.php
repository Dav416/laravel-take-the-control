<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProyeccionFinanciera;
use App\Models\Usuario;
use App\Models\CategoriaProyeccion;

class ProyeccionFinancieraSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener usuarios y categorías
        $usuario1 = Usuario::where('correo_usuario', 'test@example.com')->first();
        $usuario2 = Usuario::where('correo_usuario', 'user_test@example.com')->first();

        $catAhorro = CategoriaProyeccion::where('nombre_categoria_proyeccion', 'Ahorro')->first();
        $catInversion = CategoriaProyeccion::where('nombre_categoria_proyeccion', 'Inversión')->first();
        $catDeuda = CategoriaProyeccion::where('nombre_categoria_proyeccion', 'Deuda')->first();

        $proyecciones = [
            [
                'nombre_proyeccion_financiera' => 'Ahorro para vacaciones 2025',
                'descripcion_proyeccion_financiera' => 'Meta de ahorro de $5,000,000 COP para viaje familiar',
                'meta_proyeccion_financiera' => 5000000,
                'categoria_id' => $catAhorro->id_categoria_proyeccion,
                'usuario_id' => $usuario1->id_usuario,
            ],
            [
                'nombre_proyeccion_financiera' => 'Fondo de emergencia',
                'descripcion_proyeccion_financiera' => 'Crear fondo de 6 meses de gastos',
                'meta_proyeccion_financiera' => 10000000,
                'categoria_id' => $catAhorro->id_categoria_proyeccion,
                'usuario_id' => $usuario1->id_usuario,
            ],
            [
                'nombre_proyeccion_financiera' => 'Inversión en CDT',
                'descripcion_proyeccion_financiera' => 'Invertir en certificado de depósito a término',
                'meta_proyeccion_financiera' => 15000000,
                'categoria_id' => $catInversion->id_categoria_proyeccion,
                'usuario_id' => $usuario2->id_usuario,
            ],
            [
                'nombre_proyeccion_financiera' => 'Pago de tarjeta de crédito',
                'descripcion_proyeccion_financiera' => 'Liquidar deuda de tarjeta',
                'meta_proyeccion_financiera' => 3000000,
                'categoria_id' => $catDeuda->id_categoria_proyeccion,
                'usuario_id' => $usuario2->id_usuario,
            ],
        ];

        foreach ($proyecciones as $proyeccion) {
            ProyeccionFinanciera::create($proyeccion);
        }
    }
}
