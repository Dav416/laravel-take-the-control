<?php

namespace App\Http\Controllers;

use App\Models\CategoriaTransaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoriaTransaccionController extends Controller
{
    /**
     * Listar categorías
     */
    public function index(Request $request)
    {
        try {
            $categorias = CategoriaTransaccion::paginate(10);

            if ($request->wantsJson()) {
                return response()->json($categorias);
            }

            return view('categorias.index', compact('categorias'));
        } catch (\Exception $e) {
            Log::error('Error listando categorías: '.$e->getMessage());
            return back()->withErrors(['error' => 'Error cargando categorías']);
        }
    }

    /**
     * Mostrar formulario crear categoría
     */
    public function create()
    {
        return view('categorias.create');
    }

    /**
     * Guardar categoría
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre_categoria' => 'required|string|max:255',
                'descripcion_categoria' => 'nullable|string',
            ]);

            $categoria = CategoriaTransaccion::create($validated);

            return redirect()->route('categorias.index')->with('success', 'Categoría creada correctamente');
        } catch (\Exception $e) {
            Log::error('Error creando categoría: '.$e->getMessage());
            return back()->withErrors(['error' => 'Error creando categoría']);
        }
    }

    /**
     * Mostrar categoría
     */
    public function show($id)
    {
        $categoria = CategoriaTransaccion::findOrFail($id);
        return view('categorias.show', compact('categoria'));
    }

    /**
     * Editar categoría
     */
    public function edit($id)
    {
        $categoria = CategoriaTransaccion::findOrFail($id);
        return view('categorias.edit', compact('categoria'));
    }

    /**
     * Actualizar categoría
     */
    public function update(Request $request, $id)
    {
        try {
            $categoria = CategoriaTransaccion::findOrFail($id);

            $validated = $request->validate([
                'nombre_categoria' => 'sometimes|string|max:255',
                'descripcion_categoria' => 'nullable|string',
            ]);

            $categoria->update($validated);

            return redirect()->route('categorias.index')->with('success', 'Categoría actualizada correctamente');
        } catch (\Exception $e) {
            Log::error('Error actualizando categoría: '.$e->getMessage());
            return back()->withErrors(['error' => 'Error actualizando categoría']);
        }
    }

    /**
     * Eliminar categoría
     */
    public function destroy($id)
    {
        try {
            $categoria = CategoriaTransaccion::findOrFail($id);
            $categoria->delete();

            return redirect()->route('categorias.index')->with('error', 'Categoría eliminada correctamente');
        } catch (\Exception $e) {
            Log::error('Error eliminando categoría: '.$e->getMessage());
            return back()->withErrors(['error' => 'Error eliminando categoría']);
        }
    }
}
