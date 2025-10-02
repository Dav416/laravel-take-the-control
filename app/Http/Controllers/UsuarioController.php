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
     * Muestra el dashboard
     */
    public function dashboard()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return view('dashboard');
    }

    /**
     * Mostrar listado de usuarios
     */
    public function index(Request $request)
    {
        try {
            $usuarios = Usuario::all();

            if ($request->wantsJson()) {
                return response()->json($usuarios);
            }

            return view('usuarios.index', compact('usuarios'));
        } catch (\Exception $e) {
            Log::error('Error en index: ' . $e->getMessage());

            if ($request->wantsJson()) {
                return response()->json(['error' => 'Error interno del servidor'], 500);
            }

            return back()->withErrors(['error' => 'Error cargando usuarios']);
        }
    }

    /**
     * Mostrar formulario para crear usuario
     */
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return view('usuarios.create');
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

            $validated['clave_usuario'] = Hash::make($validated['clave_usuario']);
            $usuario = Usuario::create($validated);

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Usuario creado exitosamente',
                    'usuario' => $usuario,
                ], 201);
            }

            return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->wantsJson()) {
                return response()->json(['errors' => $e->errors()], 422);
            }
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error creando usuario: ' . $e->getMessage());

            if ($request->wantsJson()) {
                return response()->json(['error' => 'Error interno del servidor'], 500);
            }
            return back()->withErrors(['error' => 'Error creando usuario']);
        }
    }

    /**
     * Mostrar un usuario específico
     */
    public function show(Request $request, $id)
    {
        try {
            $usuario = Usuario::findOrFail($id);

            if ($request->wantsJson()) {
                return response()->json($usuario);
            }

            return view('usuarios.show', compact('usuario'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Usuario no encontrado'], 404);
            }
            return back()->withErrors(['error' => 'Usuario no encontrado']);
        } catch (\Exception $e) {
            Log::error('Error mostrando usuario: ' . $e->getMessage());

            if ($request->wantsJson()) {
                return response()->json(['error' => 'Error interno del servidor'], 500);
            }
            return back()->withErrors(['error' => 'Error mostrando usuario']);
        }
    }

    public function edit($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $usuario = Usuario::findOrFail($id);
        return view('usuarios.edit', compact('usuario'));
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

            if (isset($validated['clave_usuario']) && $validated['clave_usuario']) {
                $validated['clave_usuario'] = Hash::make($validated['clave_usuario']);
            } else {
                unset($validated['clave_usuario']);
            }

            $usuario->update($validated);

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Usuario actualizado exitosamente',
                    'usuario' => $usuario->fresh(),
                ]);
            }

            return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Usuario no encontrado'], 404);
            }
            return back()->withErrors(['error' => 'Usuario no encontrado']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->wantsJson()) {
                return response()->json(['errors' => $e->errors()], 422);
            }
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error actualizando usuario: ' . $e->getMessage());

            if ($request->wantsJson()) {
                return response()->json(['error' => 'Error interno del servidor'], 500);
            }
            return back()->withErrors(['error' => 'Error actualizando usuario']);
        }
    }

    /**
     * Eliminar usuario
    */
    public function destroy(Request $request, $id)
    {
        try {
            $usuario = Usuario::findOrFail($id);
            $usuario->delete();

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Usuario eliminado exitosamente']);
            }

            return redirect()->route('usuarios.index')->with('error', 'Usuario eliminado correctamente');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Usuario no encontrado'], 404);
            }
            return back()->withErrors(['error' => 'Usuario no encontrado']);
        } catch (\Exception $e) {
            Log::error('Error eliminando usuario: ' . $e->getMessage());

            if ($request->wantsJson()) {
                return response()->json(['error' => 'Error interno del servidor'], 500);
            }
            return back()->withErrors(['error' => 'Error eliminando usuario']);
        }
    }


    /**
     * Muestra el formulario de login
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('login');
    }

    /**
     * Procesa el login
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

            // 4. Autenticar con Laravel Auth
            Auth::login($usuario, $request->filled('remember'));
            $request->session()->regenerate();

            if($request->wantsJson()) {
                $token = $usuario->createToken('auth_token')->plainTextToken;
                return response()->json([
                    'message' => 'Login exitoso',
                    'token' => $token
                ], 200);
            }

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
     * Logout de usuario
     */
    public function logout(Request $request)
    {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            if($request->wantsJson()) {
                return response()->json([
                    'message' => 'Logout exitoso'
                ], 200);
            }

            return redirect()->route('login');
        } catch (\Exception $e) {
            Log::error('Error en logout: ' . $e->getMessage());
            return back()->withErrors([
                'error' => 'Error interno en el logout'
            ]);
        }
    }
}
