<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsuarioFeatureTest extends TestCase
{

    /**
     * Refresca la base de datos antes de cada prueba.
     */
    use RefreshDatabase;

    /**
     * Se ejecuta antes de cada prueba.
     * Aquí se autentica un usuario mediante Sanctum,
     * ya que todas las rutas están protegidas por el middleware `auth:sanctum`.
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @var Usuario $usuario */
        $usuario = Usuario::factory()->create();

        // Simula un usuario autenticado con Sanctum
        $this->actingAs($usuario, 'sanctum');
    }

    /**
     * Prueba endpoint: GET /api/usuarios
     * Debe retornar un listado con los usuarios existentes.
     * Se valida que al menos existan los 3 usuarios creados
     * durante la prueba, sin depender del total real.
     */
    public function test_api_listar_usuarios()
    {
        Usuario::factory()->count(3)->create();

        $response = $this->getJson('/api/usuarios');

        $response->assertStatus(200);

        // Verifica que al menos los 3 usuarios creados estén presentes
        $this->assertGreaterThanOrEqual(3, count($response->json()));
    }

    /**
     * Prueba endpoint: POST /api/usuarios
     * Debe crear un usuario y retornar código HTTP 201 con los datos básicos.
     */
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

        // Verifica que se guardó en la base de datos
        $this->assertDatabaseHas('Usuarios', [
            'correo_usuario' => 'test@example.com',
        ]);
    }

    /**
     * Prueba endpoint: GET /api/usuarios/{id}
     * Debe retornar los datos del usuario solicitado.
     */
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

    /**
     * Prueba endpoint: PUT /api/usuarios/{id}
     * Debe actualizar los datos del usuario.
     */
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

    /**
     * Prueba endpoint: DELETE /api/usuarios/{id}
     * Debe aplicar eliminado lógico (soft delete).
     */
    public function test_api_eliminar_usuario(): void
    {
        $usuario = Usuario::factory()->create();
        $usuarioId = $usuario->id_usuario;

        $response = $this->deleteJson("/api/usuarios/{$usuario->id_usuario}");

        $response->assertStatus(200);

        $this->assertSoftDeleted('Usuarios', [
            'id_usuario' => $usuarioId,
        ]);
    }
}
