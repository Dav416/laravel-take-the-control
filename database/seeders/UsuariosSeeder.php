<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;

class UsuariosSeeder extends Seeder
{
    public function run(): void
    {
        Usuario::create([
            'nombre_usuario'        => 'Usuario Test',
            'nombre_cuenta_usuario' => 'test',
            'correo_usuario'        => 'test@example.com',
            'clave_usuario'         => bcrypt('password123'),
        ]);

        Usuario::create([
            'nombre_usuario'        => 'Usuario Prueba',
            'nombre_cuenta_usuario' => 'user_test',
            'correo_usuario'        => 'user_test@example.com',
            'clave_usuario'         => bcrypt('password123'),
        ]);

        // 10 usuarios generados con factory
        Usuario::factory()->count(10)->create();
    }
}
