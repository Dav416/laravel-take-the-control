<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UsuarioController extends Controller
{
    /**
     * Mostrar listado de usuarios
     */
    public function index()
    {
        try {
            $usuarios = Usuario::all();
            return response()->json($usuarios);
        } catch (\Exception $e) {
            Log::error('Error en index: ' . $e->getMessage());
            return response()->json(['error' => 'Error interno del servidor'], 500);
        }
    }

    /**
     * Crear nuevo usuario
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre_usuario' => 'required|string|max:255',
                'nombre_cuenta_usuario' => 'required|string|max:255|unique:usuarios,nombre_cuenta_usuario',
                'correo_usuario' => 'required|email|unique:usuarios,correo_usuario',
                'clave_usuario' => 'required|string|min:6',
            ]);

            // Hashear la contraseña
            $validated['clave_usuario'] = Hash::make($validated['clave_usuario']);

            $usuario = Usuario::create($validated);

            return response()->json([
                'message' => 'Usuario creado exitosamente',
                'usuario' => $usuario,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error creando usuario: ' . $e->getMessage());
            return response()->json(['error' => 'Error interno del servidor'], 500);
        }
    }

    /**
     * Mostrar un usuario específico
     */
    public function show($id)
    {
        try {
            $usuario = Usuario::findOrFail($id);
            return response()->json($usuario);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        } catch (\Exception $e) {
            Log::error('Error mostrando usuario: ' . $e->getMessage());
            return response()->json(['error' => 'Error interno del servidor'], 500);
        }
    }

    /**
     * Actualizar usuario
     */
    public function update(Request $request, $id)
    {
        try {
            $usuario = Usuario::findOrFail($id);

            $validated = $request->validate([
                'nombre_usuario' => 'sometimes|string|max:255',
                'nombre_cuenta_usuario' => "sometimes|string|max:255|unique:usuarios,nombre_cuenta_usuario,{$id},id_usuario",
                'correo_usuario' => "sometimes|email|unique:usuarios,correo_usuario,{$id},id_usuario",
                'clave_usuario' => 'nullable|string|min:6',
            ]);

            // Hashear la contraseña si se proporciona
            if (isset($validated['clave_usuario'])) {
                $validated['clave_usuario'] = Hash::make($validated['clave_usuario']);
            }

            $usuario->update($validated);

            return response()->json([
                'message' => 'Usuario actualizado exitosamente',
                'usuario' => $usuario,
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error actualizando usuario: ' . $e->getMessage());
            return response()->json(['error' => 'Error interno del servidor'], 500);
        }
    }

    /**
     * Eliminar usuario
     */
    public function destroy($id)
    {
        try {
            $usuario = Usuario::findOrFail($id);
            $usuario->delete();

            return response()->json(['message' => 'Usuario eliminado exitosamente']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        } catch (\Exception $e) {
            Log::error('Error eliminando usuario: ' . $e->getMessage());
            return response()->json(['error' => 'Error interno del servidor'], 500);
        }
    }

    /**
     * Login de usuario
     */
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'correo_usuario' => 'required|email',
                'clave_usuario' => 'required|string',
            ]);

            // Intento de autenticación con los campos personalizados
            if (Auth::attempt([
                'correo_usuario' => $credentials['correo_usuario'],
                'password' => $credentials['clave_usuario']
            ])) {
                $user = Auth::user();
                return response()->json([
                    'message' => 'Inicio de sesión exitoso',
                    'usuario' => $user,
                ]);
            }

            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error en login: ' . $e->getMessage());
            return response()->json(['error' => 'Error interno del servidor'], 500);
        }
    }

    /**
     * Logout de usuario
     */
    public function logout()
    {
        try {
            Auth::logout();
            return response()->json(['message' => 'Sesión cerrada correctamente']);
        } catch (\Exception $e) {
            Log::error('Error en logout: ' . $e->getMessage());
            return response()->json(['error' => 'Error interno del servidor'], 500);
        }
    }
}
