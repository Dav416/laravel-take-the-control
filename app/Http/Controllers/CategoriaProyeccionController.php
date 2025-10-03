<?php

namespace App\Http\Controllers;

use App\Models\CategoriaProyeccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoriaProyeccionController extends Controller
{
    public function index(Request $request)
    {
        $categorias = CategoriaProyeccion::paginate(10);

        if ($request->wantsJson()) {
            return response()->json($categorias);
        }

        return view('categorias_proyecciones.index', compact('categorias'));
    }

    public function create()
    {
        return view('categorias_proyecciones.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre_categoria_proyeccion' => 'required|string|max:255',
                'descripcion_categoria_proyecciones' => 'nullable|string',
            ]);

            CategoriaProyeccion::create($validated);

            return redirect()->route('categorias-proyecciones.index')
                             ->with('success', 'Categoría creada correctamente');
        } catch (\Exception $e) {
            Log::error('Error creando categoría de proyección: '.$e->getMessage());
            return back()->withErrors(['error' => 'Error creando categoría']);
        }
    }

    public function show($id)
    {
        $categoria = CategoriaProyeccion::findOrFail($id);
        return view('categorias_proyecciones.show', compact('categoria'));
    }

    public function edit($id)
    {
        $categoria = CategoriaProyeccion::findOrFail($id);
        return view('categorias_proyecciones.edit', compact('categoria'));
    }

    public function update(Request $request, $id)
    {
        try {
            $categoria = CategoriaProyeccion::findOrFail($id);

            $validated = $request->validate([
                'nombre_categoria_proyeccion' => 'sometimes|string|max:255',
                'descripcion_categoria_proyecciones' => 'nullable|string',
            ]);

            $categoria->update($validated);

            return redirect()->route('categorias-proyecciones.index')
                             ->with('success', 'Categoría actualizada correctamente');
        } catch (\Exception $e) {
            Log::error('Error actualizando categoría: '.$e->getMessage());
            return back()->withErrors(['error' => 'Error actualizando categoría']);
        }
    }

    public function destroy($id)
    {
        try {
            $categoria = CategoriaProyeccion::findOrFail($id);
            $categoria->delete();

            return redirect()->route('categorias-proyecciones.index')
                             ->with('error', 'Categoría eliminada correctamente');
        } catch (\Exception $e) {
            Log::error('Error eliminando categoría: '.$e->getMessage());
            return back()->withErrors(['error' => 'Error eliminando categoría']);
        }
    }
}
