<?php

namespace App\Http\Controllers;

use App\Models\ProyeccionFinanciera;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProyeccionFinancieraController extends Controller
{
    public function index(Request $request)
    {
        $proyecciones = ProyeccionFinanciera::with(['usuario'])->paginate(10);

        if ($request->wantsJson()) {
            return response()->json($proyecciones);
        }

        return view('proyecciones.index', compact('proyecciones'));
    }

    public function create()
    {
        return view('proyecciones.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre_proyeccion_financiera'   => 'required|string|max:255',
                'descripcion_proyeccion_financiera' => 'nullable|string',
                'meta_proyeccion_financiera'    => 'required|numeric',
                'Categorias_id_categoria'       => 'nullable|exists:CategoriasProyecciones,id_categoria_proyeccion',
            ]);

            // Asignar al usuario autenticado
            $validated['Usuarios_id_usuario'] = Auth::id();

            ProyeccionFinanciera::create($validated);

            return redirect()->route('proyecciones.index')->with('success', 'Proyección creada correctamente');
        } catch (\Exception $e) {
            Log::error('Error creando proyección: '.$e->getMessage());
            return back()->withErrors(['error' => 'Error creando proyección']);
        }
    }

    public function show($id)
    {
        $proyeccion = ProyeccionFinanciera::with(['usuario'])->findOrFail($id);
        return view('proyecciones.show', compact('proyeccion'));
    }

    public function edit($id)
    {
        $proyeccion = ProyeccionFinanciera::findOrFail($id);
        return view('proyecciones.edit', compact('proyeccion'));
    }

    public function update(Request $request, $id)
    {
        try {
            $proyeccion = ProyeccionFinanciera::findOrFail($id);

            $validated = $request->validate([
                'nombre_proyeccion_financiera'   => 'sometimes|string|max:255',
                'descripcion_proyeccion_financiera' => 'nullable|string',
                'meta_proyeccion_financiera'    => 'sometimes|numeric',
                'Categorias_id_categoria'       => 'nullable|exists:CategoriasProyecciones,id_categoria_proyeccion',
            ]);

            $proyeccion->update($validated);

            return redirect()->route('proyecciones.index')->with('success', 'Proyección actualizada correctamente');
        } catch (\Exception $e) {
            Log::error('Error actualizando proyección: '.$e->getMessage());
            return back()->withErrors(['error' => 'Error actualizando proyección']);
        }
    }

    public function destroy($id)
    {
        try {
            $proyeccion = ProyeccionFinanciera::findOrFail($id);
            $proyeccion->delete();

            return redirect()->route('proyecciones.index')->with('error', 'Proyección eliminada correctamente');
        } catch (\Exception $e) {
            Log::error('Error eliminando proyección: '.$e->getMessage());
            return back()->withErrors(['error' => 'Error eliminando proyección']);
        }
    }
}
