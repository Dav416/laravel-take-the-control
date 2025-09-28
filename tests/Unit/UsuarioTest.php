<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsuarioTest extends TestCase
{
    use RefreshDatabase;

    public function test_model_crear_un_usuario()
    {
        $usuario = Usuario::factory()->create();

        $this->assertDatabaseHas('Usuarios', [
            'id_usuario' => $usuario->id_usuario,
            'correo_usuario' => $usuario->correo_usuario,
        ]);
    }

    public function test_model_eliminar_un_usuario(): void
    {
        $usuario = Usuario::factory()->create();
        $usuarioId = $usuario->id_usuario;

        $usuario->delete();

        $this->assertSoftDeleted('Usuarios', [
            'id_usuario' => $usuarioId,
        ]);
    }


    /**
     * Test hecho para que falle
     */
    // public function test_model_no_eliminar_un_usuario()
    // {
    //     $usuario = Usuario::factory()->create();
    //     $usuarioId = $usuario->id_usuario;

    //     $usuario->delete();

    //     $this->assertDatabaseMissing('Usuarios', [
    //         'id_usuario' => $usuarioId,
    //     ]);
    // }
}
