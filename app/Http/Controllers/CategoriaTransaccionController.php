<?php

namespace App\Http\Controllers;

use App\Models\CategoriaTransaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CategoriaTransaccionController extends Controller
{
    /**
     * Listar categorías
     */
    public function index(Request $request)
    {
        try {
            $categorias = CategoriaTransaccion::where(function($q) {
                    $q->where('usuario_id', Auth::user()->id_usuario)
                      ->orWhereNull('usuario_id');
                })
                ->orderBy('nombre_categoria_transaccion')->paginate(15);

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
                'nombre_categoria_transaccion' => 'required|string|max:255|unique:categorias_transacciones,nombre_categoria_transaccion,NULL,id_categoria_transaccion,usuario_id,' . Auth::user()->id_usuario,
                'descripcion_categoria_transaccion' => 'nullable|string',
            ]);

            CategoriaTransaccion::create($validated);

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
        $categoria = CategoriaTransaccion::where(function($q) {
                $q->where('usuario_id', Auth::user()->id_usuario)
                  ->orWhereNull('usuario_id');
            })
            ->with('transacciones')->findOrFail($id);

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

        $categoria = CategoriaTransaccion::where('usuario_id', Auth::user()->id_usuario)
            ->findOrFail($id);
        return view('categorias.edit', compact('categoria'));
    }

    /**
     * Actualizar categoría
     */
    public function update(Request $request, $id)
    {
        try {
            $categoria = CategoriaTransaccion::where('usuario_id', Auth::user()->id_usuario)
                ->findOrFail($id);

            $validated = $request->validate([
                'nombre_categoria_transaccion' => 'required|string|max:255|unique:categorias_transacciones,nombre_categoria_transaccion,' . $id . ',id_categoria_transaccion,usuario_id,' . Auth::user()->id_usuario,
                'descripcion_categoria_transaccion' => 'nullable|string',
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
            $categoria = CategoriaTransaccion::findOrFail($id);

            // Solo se pueden eliminar registros propios del usuario, no los por defecto
            if ($categoria->usuario_id !== Auth::user()->id_usuario) {
                return back()->withErrors(['error' => 'No autorizado']);
            }

            // Verificar si tiene transacciones asociadas
            if ($categoria->transacciones()->count() > 0) {
                return back()->withErrors([
                    'error' => 'No se puede eliminar esta categoría porque tiene transacciones asociadas'
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
