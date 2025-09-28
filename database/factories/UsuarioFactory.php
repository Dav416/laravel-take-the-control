<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;

    public function definition()
    {
        return [
            'nombre_usuario'        => $this->faker->name(),
            'nombre_cuenta_usuario' => $this->faker->unique()->userName(),
            'correo_usuario'        => $this->faker->unique()->safeEmail(),
            'clave_usuario'         => Hash::make('password123'),
        ];
    }
}
