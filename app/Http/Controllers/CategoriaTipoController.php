<?php

namespace App\Http\Controllers;

use App\Models\CategoriaTipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CategoriaTipoController extends Controller
{
    /**
     * Listar categorías
     */
    public function index(Request $request)
    {
        try {
            $categorias = CategoriaTipo::orderBy('nombre_categoria_tipo')->paginate(15);

            if ($request->wantsJson()) {
                return response()->json($categorias);
            }

            return view('categorias.index', compact('categorias'));
        } catch (\Exception $e) {
            Log::error('Error listando categorías: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error cargando categorías']);
        }
    }

    /**
     * Mostrar formulario crear categoría
     */
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return view('categorias.create');
    }

    /**
     * Guardar categoría
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre_categoria_tipo' => 'required|string|max:255|unique:categorias_tipos,nombre_categoria_tipo',
                'descripcion_categoria_tipo' => 'nullable|string',
            ]);

            CategoriaTipo::create($validated);

            return redirect()->route('categorias.index')
                ->with('success', 'Categoría creada correctamente');
        } catch (\Exception $e) {
            Log::error('Error creando categoría: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error creando categoría'])->withInput();
        }
    }

    /**
     * Mostrar categoría
     */
    public function show($id)
    {
        $categoria = CategoriaTipo::with('tipos')->findOrFail($id);

        if (request()->wantsJson()) {
            return response()->json($categoria);
        }

        return view('categorias.show', compact('categoria'));
    }

    /**
     * Editar categoría
     */
    public function edit($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $categoria = CategoriaTipo::findOrFail($id);
        return view('categorias.edit', compact('categoria'));
    }

    /**
     * Actualizar categoría
     */
    public function update(Request $request, $id)
    {
        try {
            $categoria = CategoriaTipo::findOrFail($id);

            $validated = $request->validate([
                'nombre_categoria_tipo' => 'required|string|max:255|unique:categorias_tipos,nombre_categoria_tipo,' . $id . ',id_categoria_tipo',
                'descripcion_categoria_tipo' => 'nullable|string',
            ]);

            $categoria->update($validated);

            return redirect()->route('categorias.index')
                ->with('success', 'Categoría actualizada correctamente');
        } catch (\Exception $e) {
            Log::error('Error actualizando categoría: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error actualizando categoría'])->withInput();
        }
    }

    /**
     * Eliminar categoría
     */
    public function destroy($id)
    {
        try {
            $categoria = CategoriaTipo::findOrFail($id);

            // Verificar si tiene tipos asociados
            if ($categoria->tipos()->count() > 0) {
                return back()->withErrors([
                    'error' => 'No se puede eliminar esta categoría porque tiene tipos asociados'
                ]);
            }

            $categoria->delete();

            return redirect()->route('categorias.index')
                ->with('success', 'Categoría eliminada correctamente');
        } catch (\Exception $e) {
            Log::error('Error eliminando categoría: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error eliminando categoría']);
        }
    }
}
