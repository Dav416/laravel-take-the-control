<?php

namespace App\Http\Controllers;

use App\Models\Transaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TransaccionController extends Controller
{

    /**
     * Listar transacciones
     */
    public function index(Request $request)
    {
        try {
            $transacciones = Transaccion::paginate(10);

            if ($request->wantsJson()) {
                return response()->json($transacciones);
            }

           return view('transacciones.index', compact('transacciones'));
        } catch (\Exception $e) {
            Log::error('Error en index transacciones: ' . $e->getMessage());

            if ($request->wantsJson()) {
                return response()->json(['error' => 'Error interno del servidor'], 500);
            }

            return back()->withErrors(['error' => 'Error cargando transacciones']);
        }
    }

    /**
     * Mostrar formulario para crear transacción
     */
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return view('transacciones.create');
    }

    /**
     * Crear nueva transacción
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre_transaccion' => 'required|string|max:255',
                'descripcion_transaccion' => 'nullable|string',
                'valor_transaccion' => 'required|numeric',
                'categoria' => 'nullable|string|max:255',
                'entidad_financiera' => 'nullable|string|max:255',
                'proyeccion_financiera' => 'nullable|string|max:255',
            ]);

            $transaccion = Transaccion::create($validated);

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Transacción creada exitosamente',
                    'transaccion' => $transaccion,
                ], 201);
            }

            return redirect()->route('transacciones.index')->with('success', 'Transacción creada correctamente');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->wantsJson()) {
                return response()->json(['errors' => $e->errors()], 422);
            }
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error creando transacción: ' . $e->getMessage());

            if ($request->wantsJson()) {
                return response()->json(['error' => 'Error interno del servidor'], 500);
            }
            return back()->withErrors(['error' => 'Error creando transacción']);
        }
    }

    /**
     * Mostrar una transacción específica
     */
    public function show(Request $request, $id)
    {
        try {
            $transaccion = Transaccion::findOrFail($id);

            if ($request->wantsJson()) {
                return response()->json($transaccion);
            }

            return view('transacciones.show', compact('transaccion'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Transacción no encontrada'], 404);
            }
            return back()->withErrors(['error' => 'Transacción no encontrada']);
        } catch (\Exception $e) {
            Log::error('Error mostrando transacción: ' . $e->getMessage());

            if ($request->wantsJson()) {
                return response()->json(['error' => 'Error interno del servidor'], 500);
            }
            return back()->withErrors(['error' => 'Error mostrando transacción']);
        }
    }

    /**
     * Formulario de edición de transacción
     */
    public function edit($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $transaccion = Transaccion::findOrFail($id);
        return view('transacciones.edit', compact('transaccion'));
    }

    /**
     * Actualizar transacción
     */
    public function update(Request $request, $id)
    {
        try {
            $transaccion = Transaccion::findOrFail($id);

            $validated = $request->validate([
                'nombre_transaccion' => 'sometimes|string|max:255',
                'descripcion_transaccion' => 'nullable|string',
                'valor_transaccion' => 'sometimes|numeric',
                'categoria' => 'nullable|string|max:255',
                'entidad_financiera' => 'nullable|string|max:255',
                'proyeccion_financiera' => 'nullable|string|max:255',
            ]);

            $transaccion->update($validated);

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Transacción actualizada exitosamente',
                    'transaccion' => $transaccion->fresh(),
                ]);
            }

            return redirect()->route('transacciones.index')->with('success', 'Transacción actualizada correctamente');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Transacción no encontrada'], 404);
            }
            return back()->withErrors(['error' => 'Transacción no encontrada']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->wantsJson()) {
                return response()->json(['errors' => $e->errors()], 422);
            }
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error actualizando transacción: ' . $e->getMessage());

            if ($request->wantsJson()) {
                return response()->json(['error' => 'Error interno del servidor'], 500);
            }
            return back()->withErrors(['error' => 'Error actualizando transacción']);
        }
    }

    /**
     * Eliminar transacción (soft delete)
     */
    public function destroy(Request $request, $id)
    {
        try {
            $transaccion = Transaccion::findOrFail($id);
            $transaccion->delete();

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Transacción eliminada exitosamente']);
            }

            return redirect()->route('transacciones.index')->with('error', 'Transacción eliminada correctamente');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Transacción no encontrada'], 404);
            }
            return back()->withErrors(['error' => 'Transacción no encontrada']);
        } catch (\Exception $e) {
            Log::error('Error eliminando transacción: ' . $e->getMessage());

            if ($request->wantsJson()) {
                return response()->json(['error' => 'Error interno del servidor'], 500);
            }
            return back()->withErrors(['error' => 'Error eliminando transacción']);
        }
    }
}
