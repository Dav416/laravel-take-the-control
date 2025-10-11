<?php

namespace App\Http\Controllers;

use App\Models\Tipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TipoController extends Controller
{
    /**
     * Listar tipos
     */
    public function index(Request $request)
    {
        try {
            $tipos = Tipo::orderBy('nombre_tipo')->paginate(15);

            if ($request->wantsJson()) {
                return response()->json($tipos);
            }

            return view('tipos.index', compact('tipos'));
        } catch (\Exception $e) {
            Log::error('Error en index tipos: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error cargando tipos']);
        }
    }

    /**
     * Mostrar formulario para crear tipo
     */
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        return view('tipos.create');
    }

    /**
     * Crear nuevo tipo
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre_tipo' => 'required|string|max:55|unique:tipos,nombre_tipo',
                'descripcion_tipo' => 'nullable|string',
            ]);

            Tipo::create($validated);

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Tipo creado exitosamente'], 201);
            }

            return redirect()->route('tipos.index')
                ->with('success', 'Tipo creado correctamente');
        } catch (\Exception $e) {
            Log::error('Error creando tipo: ' . $e->getMessage());

            if ($request->wantsJson()) {
                return response()->json(['error' => 'Error creando tipo'], 500);
            }

            return back()->withErrors(['error' => 'Error creando tipo'])->withInput();
        }
    }

    /**
     * Mostrar un tipo específico
     */
    public function show($id)
    {
        $tipo = Tipo::with('transacciones')->findOrFail($id);

        if (request()->wantsJson()) {
            return response()->json($tipo);
        }

        return view('tipos.show', compact('tipo'));
    }

    /**
     * Formulario de edición de tipo
     */
    public function edit($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $tipo = Tipo::findOrFail($id);
        return view('tipos.edit', compact('tipo'));
    }

    /**
     * Actualizar tipo
     */
    public function update(Request $request, $id)
    {
        try {
            $tipo = Tipo::findOrFail($id);

            $validated = $request->validate([
                'nombre_tipo' => 'required|string|max:55|unique:tipos,nombre_tipo,' . $id . ',id_tipo',
                'descripcion_tipo' => 'nullable|string',
            ]);

            $tipo->update($validated);

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Tipo actualizado exitosamente']);
            }

            return redirect()->route('tipos.index')
                ->with('success', 'Tipo actualizado correctamente');
        } catch (\Exception $e) {
            Log::error('Error actualizando tipo: ' . $e->getMessage());

            if ($request->wantsJson()) {
                return response()->json(['error' => 'Error actualizando tipo'], 500);
            }

            return back()->withErrors(['error' => 'Error actualizando tipo'])->withInput();
        }
    }

    /**
     * Eliminar tipo
     */
    public function destroy(Request $request, Tipo $tipo)
    {
        try {
            // Verificar si tiene transacciones asociadas
            if ($tipo->transacciones()->count() > 0) {
                if ($request->wantsJson()) {
                    return response()->json(['error' => 'No se puede eliminar un tipo con transacciones asociadas'], 400);
                }
                return back()->withErrors(['error' => 'No se puede eliminar un tipo con transacciones asociadas']);
            }

            $tipo->delete();

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Tipo eliminado exitosamente']);
            }

            return redirect()->route('tipos.index')
                ->with('success', 'Tipo eliminado correctamente');
        } catch (\Exception $e) {
            Log::error('Error eliminando tipo: ' . $e->getMessage());

            if ($request->wantsJson()) {
                return response()->json(['error' => 'Error interno del servidor'], 500);
            }

            return back()->withErrors(['error' => 'Error eliminando tipo']);
        }
    }
}
