<?php

namespace App\Http\Controllers;

use App\Models\Transaccion;
use App\Models\CategoriaTransaccion;
use App\Models\EntidadFinanciera;
use App\Models\ProyeccionFinanciera;
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
            $transacciones = Transaccion::with(['categoria', 'entidadFinanciera', 'proyeccion'])
                ->paginate(10);

            if ($request->wantsJson()) {
                return response()->json($transacciones);
            }

            return view('transacciones.index', compact('transacciones'));
        } catch (\Exception $e) {
            Log::error('Error en index transacciones: ' . $e->getMessage());
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

        $categorias = CategoriaTransaccion::all();
        $entidades = EntidadFinanciera::all();
        $proyecciones = ProyeccionFinanciera::all();

        return view('transacciones.create', compact('categorias', 'entidades', 'proyecciones'));
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
                'Categorias_id_categoria_transaccion' => 'required|exists:CategoriasTransacciones,id_categoria_transaccion',
                'EntidadesFinancieras_id_entidad_financiera' => 'required|exists:EntidadesFinancieras,id_entidad_financiera',
                'ProyeccionesFinancieras_id_proyeccion_financiera' => 'required|exists:ProyeccionesFinancieras,id_proyeccion_financiera',
            ]);

            $transaccion = Transaccion::create($validated);

            return redirect()->route('transacciones.index')
                ->with('success', 'Transacción creada correctamente');
        } catch (\Exception $e) {
            Log::error('Error creando transacción: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error creando transacción'])->withInput();
        }
    }

    /**
     * Mostrar una transacción específica
     */
    public function show($id)
    {
        $transaccion = Transaccion::with(['categoria', 'entidadFinanciera', 'proyeccion'])
            ->findOrFail($id);

        return view('transacciones.show', compact('transaccion'));
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
        $categorias = CategoriaTransaccion::all();
        $entidades = EntidadFinanciera::all();
        $proyecciones = ProyeccionFinanciera::all();

        return view('transacciones.edit', compact('transaccion', 'categorias', 'entidades', 'proyecciones'));
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
                'Categorias_id_categoria_transaccion' => 'required|exists:CategoriasTransacciones,id_categoria_transaccion',
                'EntidadesFinancieras_id_entidad_financiera' => 'required|exists:EntidadesFinancieras,id_entidad_financiera',
                'ProyeccionesFinancieras_id_proyeccion_financiera' => 'required|exists:ProyeccionesFinancieras,id_proyeccion_financiera',
            ]);

            $transaccion->update($validated);

            return redirect()->route('transacciones.index')
                ->with('success', 'Transacción actualizada correctamente');
        } catch (\Exception $e) {
            Log::error('Error actualizando transacción: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error actualizando transacción'])->withInput();
        }
    }

    /**
     * Eliminar transacción
     */
    public function destroy($id)
    {
        try {
            $transaccion = Transaccion::findOrFail($id);
            $transaccion->delete();

            return redirect()->route('transacciones.index')
                ->with('error', 'Transacción eliminada correctamente');
        } catch (\Exception $e) {
            Log::error('Error eliminando transacción: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error eliminando transacción']);
        }
    }
}
