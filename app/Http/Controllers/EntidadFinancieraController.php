<?php

namespace App\Http\Controllers;

use App\Models\EntidadFinanciera;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EntidadFinancieraController extends Controller
{
    public function index(Request $request)
    {

        try {
            $entidades = EntidadFinanciera::orderBy('nombre_entidad_financiera')->paginate(15);

            if ($request->wantsJson()) {
                return response()->json($entidades);
            }

            return view('entidades.index', compact('entidades'));
        } catch (\Exception $e) {
            Log::error('Error listando entidades: '.$e->getMessage());
            return back()->withErrors(['error' => 'Error listando entidades']);
        }
    }

    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        return view('entidades.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre_entidad_financiera' => 'required|string|max:255',
                'descripcion_entidad_financiera' => 'nullable|string',
            ]);

            EntidadFinanciera::create($validated);

            return redirect()->route('entidades.index')->with('success', 'Entidad creada correctamente');
        } catch (\Exception $e) {
            Log::error('Error creando entidad: '.$e->getMessage());
            return back()->withErrors(['error' => 'Error creando entidad']);
        }
    }

    public function show($id)
    {
        $entidad = EntidadFinanciera::findOrFail($id);

        if (request()->wantsJson()) {
            return response()->json($entidad);
        }

        return view('entidades.show', compact('entidad'));
    }

    public function edit($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $entidad = EntidadFinanciera::findOrFail($id);
        return view('entidades.edit', compact('entidad'));
    }

    public function update(Request $request, $id)
    {
        try {
            $entidad = EntidadFinanciera::findOrFail($id);

            $validated = $request->validate([
                'nombre_entidad_financiera' => 'sometimes|string|max:255',
                'descripcion_entidad_financiera' => 'nullable|string',
            ]);

            $entidad->update($validated);

            return redirect()->route('entidades.index')->with('success', 'Entidad actualizada correctamente');
        } catch (\Exception $e) {
            Log::error('Error actualizando entidad: '.$e->getMessage());
            return back()->withErrors(['error' => 'Error actualizando entidad']);
        }
    }

    public function destroy($id)
    {
        try {
            $entidad = EntidadFinanciera::findOrFail($id);

            // Verificar si tiene transacciones asociadas
            if ($entidad->transacciones()->count() > 0) {
                return back()->withErrors([
                    'error' => 'No se puede eliminar esta entidad porque tiene transacciones asociadas'
                ]);
            }

            $entidad->delete();

            return redirect()->route('entidades.index')->with('error', 'Entidad eliminada correctamente');
        } catch (\Exception $e) {
            Log::error('Error eliminando entidad: '.$e->getMessage());
            return back()->withErrors(['error' => 'Error eliminando entidad']);
        }
    }
}
