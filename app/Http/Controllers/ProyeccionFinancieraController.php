<?php

namespace App\Http\Controllers;

use App\Models\ProyeccionFinanciera;
use App\Models\CategoriaProyeccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProyeccionFinancieraController extends Controller
{
    /**
     * Listar proyecciones del usuario
     */
    public function index(Request $request)
    {
        try {
            $proyecciones = ProyeccionFinanciera::with(['categoriaProyeccion', 'transacciones'])
                ->where('usuario_id', Auth::user()->id_usuario)
                ->orderBy('fecha_creacion', 'desc')
                ->paginate(15);

            // Calcular progreso para cada proyección
            foreach ($proyecciones as $proyeccion) {
                $proyeccion->progreso_actual = $this->calcularProgreso($proyeccion);
                $proyeccion->porcentaje = $proyeccion->meta_proyeccion_financiera > 0
                    ? ($proyeccion->progreso_actual / $proyeccion->meta_proyeccion_financiera) * 100
                    : 0;
            }

            if ($request->wantsJson()) {
                return response()->json($proyecciones);
            }

            return view('proyecciones.index', compact('proyecciones'));
        } catch (\Exception $e) {
            Log::error('Error listando proyecciones: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error cargando proyecciones']);
        }
    }

    /**
     * Mostrar formulario crear proyección
     */
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $categorias = CategoriaProyeccion::orderBy('nombre_categoria_proyeccion')->get();
        return view('proyecciones.create', compact('categorias'));
    }

    /**
     * Guardar proyección
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre_proyeccion_financiera' => 'required|string|max:255',
                'descripcion_proyeccion_financiera' => 'nullable|string',
                'meta_proyeccion_financiera' => 'required|numeric|min:0',
                'categoria_id' => 'required|exists:categorias_proyecciones,id_categoria_proyeccion',
            ]);

            $validated['usuario_id'] = Auth::user()->id_usuario;

            ProyeccionFinanciera::create($validated);

            return redirect()->route('proyecciones.index')
                ->with('success', 'Proyección financiera creada correctamente');
        } catch (\Exception $e) {
            Log::error('Error creando proyección: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error creando proyección'])->withInput();
        }
    }

    /**
     * Mostrar proyección específica
     */
    public function show($id)
    {
        $proyeccion = ProyeccionFinanciera::with(['categoriaProyeccion', 'transacciones.tipo.categoria'])
            ->where('usuario_id', Auth::user()->id_usuario)
            ->findOrFail($id);

        $proyeccion->progreso_actual = $this->calcularProgreso($proyeccion);
        $proyeccion->porcentaje = $proyeccion->meta_proyeccion_financiera > 0
            ? ($proyeccion->progreso_actual / $proyeccion->meta_proyeccion_financiera) * 100
            : 0;

        if (request()->wantsJson()) {
            return response()->json($proyeccion);
        }

        return view('proyecciones.show', compact('proyeccion'));
    }

    /**
     * Editar proyección
     */
    public function edit($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $proyeccion = ProyeccionFinanciera::where('usuario_id', Auth::user()->id_usuario)
            ->findOrFail($id);

        $categorias = CategoriaProyeccion::orderBy('nombre_categoria_proyeccion')->get();

        return view('proyecciones.edit', compact('proyeccion', 'categorias'));
    }

    /**
     * Actualizar proyección
     */
    public function update(Request $request, $id)
    {
        try {
            $proyeccion = ProyeccionFinanciera::where('usuario_id', Auth::user()->id_usuario)
                ->findOrFail($id);

            $validated = $request->validate([
                'nombre_proyeccion_financiera' => 'required|string|max:255',
                'descripcion_proyeccion_financiera' => 'nullable|string',
                'meta_proyeccion_financiera' => 'required|numeric|min:0',
                'categoria_id' => 'required|exists:categorias_proyecciones,id_categoria_proyeccion',
            ]);

            $proyeccion->update($validated);

            return redirect()->route('proyecciones.index')
                ->with('success', 'Proyección financiera actualizada correctamente');
        } catch (\Exception $e) {
            Log::error('Error actualizando proyección: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error actualizando proyección'])->withInput();
        }
    }

    /**
     * Eliminar proyección
     */
    public function destroy($id)
    {
        try {
            $proyeccion = ProyeccionFinanciera::where('usuario_id', Auth::user()->id_usuario)
                ->findOrFail($id);

            // Verificar si tiene transacciones asociadas
            if ($proyeccion->transacciones()->count() > 0) {
                return back()->withErrors([
                    'error' => 'No se puede eliminar esta proyección porque tiene transacciones asociadas'
                ]);
            }

            $proyeccion->delete();

            return redirect()->route('proyecciones.index')
                ->with('success', 'Proyección financiera eliminada correctamente');
        } catch (\Exception $e) {
            Log::error('Error eliminando proyección: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error eliminando proyección']);
        }
    }

    /**
     * Calcular progreso actual de una proyección
     */
    private function calcularProgreso(ProyeccionFinanciera $proyeccion)
    {
        $progreso = 0;

        foreach ($proyeccion->transacciones as $transaccion) {
            // Obtener la categoría del tipo (Ingreso/Egreso)
            $categoriaTipo = $transaccion->tipo->categoria->nombre_categoria_tipo ?? null;

            if ($categoriaTipo === 'Ingreso') {
                // Si es ingreso, se suma al progreso
                $progreso += $transaccion->valor_transaccion;
            } elseif ($categoriaTipo === 'Egreso') {
                // Si es egreso, se resta del progreso
                $progreso -= $transaccion->valor_transaccion;
            }
        }

        return max(0, $progreso); // No permitir progreso negativo
    }
}
