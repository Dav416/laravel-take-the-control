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
                'nombre_cuenta_usuario' => 'required|string|max:255|unique:Usuarios,nombre_cuenta_usuario',
                'correo_usuario' => 'required|email|max:255|unique:Usuarios,correo_usuario',
                'clave_usuario' => 'required|string|min:6',
            ]);


            $usuario = Usuario::create($validated);

            return response()->json([
                'message' => 'Usuario creado exitosamente',
                'usuario' => $usuario,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error creando usuario: ' . $e->getMessage());
            return response()->json(['error' => 'Error interno del servidor: ' . $e->getMessage()], 500);
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
                'nombre_cuenta_usuario' => "sometimes|string|max:255|unique:Usuarios,nombre_cuenta_usuario,{$id},id_usuario",
                'correo_usuario' => "sometimes|email|max:255|unique:Usuarios,correo_usuario,{$id},id_usuario",
                'clave_usuario' => 'nullable|string|min:6',
            ]);

            // Remover campos vacíos para evitar sobreescribir con null
            $validated = array_filter($validated, function($value) {
                return $value !== null && $value !== '';
            });

            $usuario->update($validated);

            return response()->json([
                'message' => 'Usuario actualizado exitosamente',
                'usuario' => $usuario->fresh(), // Obtener la versión actualizada
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error actualizando usuario: ' . $e->getMessage());
            return response()->json(['error' => 'Error interno del servidor: ' . $e->getMessage()], 500);
        }
    }

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
     * Muestra el formulario de login (GET)
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Muestra el dashboard (GET)
     */
    public function dashboard()
    {
        if (!session('usuario')) {
            return redirect()->route('login');
        }

        return view('dashboard');
    }


    /**
     * Procesa el login (POST)
     */
    public function login(Request $request)
    {
        try {
            // 1. Validar inputs
            $credentials = $request->validate([
                'correo_usuario' => 'required|email',
                'clave_usuario'  => 'required|string',
            ]);

            // 2. Buscar usuario por correo
            $usuario = Usuario::where('correo_usuario', $credentials['correo_usuario'])->first();

            if (!$usuario) {
                return back()->withErrors([
                    'correo_usuario' => 'Verifique su correo electrónico'
                ])->withInput();
            }

            // 3. Validar contraseña
            if (!Hash::check($credentials['clave_usuario'], $usuario->clave_usuario)) {
                return back()->withErrors([
                    'clave_usuario' => 'Verifique su contraseña'
                ])->withInput();
            }

            // 4. Guardar usuario en sesión
            session(['usuario' => $usuario]);

            // 5. Redirigir al dashboard
            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            Log::error('Error en login: ' . $e->getMessage());
            return back()->withErrors([
                'error' => 'Error interno, intenta más tarde.'
            ]);
        }
    }

    /**
     * Logout de usuario (POST)
     */
    public function logout(Request $request)
    {
        try {
            $request->session()->forget('usuario');
            return redirect()->route('login');
        } catch (\Exception $e) {
            Log::error('Error en logout: ' . $e->getMessage());
            return back()->withErrors([
                'error' => 'Error interno en el logout'
            ]);
        }
    }
}
