<?php

namespace App\Http\Controllers;

use App\Models\CategoriaProyeccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CategoriaProyeccionController extends Controller
{
    /**
     * Listar categorías
     */
    public function index(Request $request)
    {
        try {
            $categorias = CategoriaProyeccion::withCount('proyecciones')
                ->orderBy('nombre_categoria_proyeccion')
                ->paginate(15);

            if ($request->wantsJson()) {
                return response()->json($categorias);
            }

            return view('categorias-proyecciones.index', compact('categorias'));
        } catch (\Exception $e) {
            Log::error('Error listando categorías de proyecciones: ' . $e->getMessage());
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

        return view('categorias-proyecciones.create');
    }

    /**
     * Guardar categoría
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre_categoria_proyeccion' => 'required|string|max:255|unique:categorias_proyecciones,nombre_categoria_proyeccion',
                'descripcion_categoria_proyeccion' => 'nullable|string',
            ]);

            CategoriaProyeccion::create($validated);

            return redirect()->route('categorias-proyecciones.index')
                ->with('success', 'Categoría creada correctamente');
        } catch (\Exception $e) {
            Log::error('Error creando categoría de proyección: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error creando categoría'])->withInput();
        }
    }

    /**
     * Editar categoría
     */
    public function edit($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $categoria = CategoriaProyeccion::findOrFail($id);
        return view('categorias-proyecciones.edit', compact('categoria'));
    }

    /**
     * Actualizar categoría
     */
    public function update(Request $request, $id)
    {
        try {
            $categoria = CategoriaProyeccion::findOrFail($id);

            $validated = $request->validate([
                'nombre_categoria_proyeccion' => 'required|string|max:255|unique:categorias_proyecciones,nombre_categoria_proyeccion,' . $id . ',id_categoria_proyeccion',
                'descripcion_categoria_proyeccion' => 'nullable|string',
            ]);

            $categoria->update($validated);

            return redirect()->route('categorias-proyecciones.index')
                ->with('success', 'Categoría actualizada correctamente');
        } catch (\Exception $e) {
            Log::error('Error actualizando categoría de proyección: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error actualizando categoría'])->withInput();
        }
    }

    /**
     * Eliminar categoría
     */
    public function destroy($id)
    {
        try {
            $categoria = CategoriaProyeccion::findOrFail($id);

            // Verificar si tiene proyecciones asociadas
            if ($categoria->proyecciones()->count() > 0) {
                return back()->withErrors([
                    'error' => 'No se puede eliminar esta categoría porque tiene proyecciones asociadas'
                ]);
            }

            $categoria->delete();

            return redirect()->route('categorias-proyecciones.index')
                ->with('success', 'Categoría eliminada correctamente');
        } catch (\Exception $e) {
            Log::error('Error eliminando categoría de proyección: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error eliminando categoría']);
        }
    }
}
