<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsuarioFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_listar_usuarios()
    {
        Usuario::factory()->count(3)->create();

        $response = $this->getJson('/api/usuarios');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function test_api_crear_usuario()
    {
        $data = [
            'nombre_usuario' => 'Test User',
            'nombre_cuenta_usuario' => 'testuser',
            'correo_usuario' => 'test@example.com',
            'clave_usuario' => '123456',
        ];

        $response = $this->postJson('/api/usuarios', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment([
                     'nombre_usuario' => 'Test User',
                     'correo_usuario' => 'test@example.com',
                 ]);

        $this->assertDatabaseHas('Usuarios', [
            'correo_usuario' => 'test@example.com',
        ]);
    }

    public function test_api_mostrar_usuario()
    {
        $usuario = Usuario::factory()->create();

        $response = $this->getJson("/api/usuarios/{$usuario->id_usuario}");

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'id_usuario' => $usuario->id_usuario,
                     'correo_usuario' => $usuario->correo_usuario,
                 ]);
    }

    public function test_api_actualizar_usuario()
    {
        $usuario = Usuario::factory()->create();

        $response = $this->putJson("/api/usuarios/{$usuario->id_usuario}", [
            'nombre_usuario' => 'Actualizado',
            'correo_usuario' => 'nuevo@example.com',
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'nombre_usuario' => 'Actualizado',
                     'correo_usuario' => 'nuevo@example.com',
                 ]);

        $this->assertDatabaseHas('Usuarios', [
            'id_usuario' => $usuario->id_usuario,
            'correo_usuario' => 'nuevo@example.com',
        ]);
    }

    public function test_api_eliminar_usuario(): void
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
    // public function test_api_error_eliminar_un_usuario()
    // {
    //     $usuario = Usuario::factory()->create();

    //     $response = $this->deleteJson("/api/usuarios/{$usuario->id_usuario}");

    //     $response->assertStatus(200)
    //              ->assertJsonFragment(['message' => 'Usuario eliminado exitosamente']);

    //     $this->assertDatabaseMissing('Usuarios', [
    //         'id_usuario' => $usuario->id_usuario,
    //     ]);
    // }
}
