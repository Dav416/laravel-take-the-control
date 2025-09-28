<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;

class UsuariosSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario administrador fijo
        Usuario::create([
            'nombre_usuario'        => 'Administrador',
            'nombre_cuenta_usuario' => 'admin',
            'correo_usuario'        => 'admin@example.com',
            'clave_usuario'         => bcrypt('admin123'),
        ]);

        // Usuario prueba fijo
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
