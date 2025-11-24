<?php

namespace App\Http\Controllers;

use App\Models\Transaccion;
use App\Models\Tipo;
use App\Models\CategoriaTransaccion;
use App\Models\EntidadFinanciera;
use App\Models\ProyeccionFinanciera;
use App\Models\SaldoDisponible;
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
            $query = Transaccion::with(['tipo', 'categoria', 'entidadFinanciera', 'proyeccionFinanciera']);

            // Si está autenticado, filtrar por usuario
            if (Auth::check()) {
                $query->where('usuario_id', Auth::id());
            }

            $transacciones = $query->orderBy('fecha_creacion', 'desc')->paginate(15);

            if ($request->wantsJson()) {
                return response()->json($transacciones);
            }

            // Obtener saldo actual
            $saldoActual = null;
            if (Auth::check()) {
                $saldoActual = SaldoDisponible::obtenerSaldo(Auth::id());
            }

            return view('transacciones.index', compact('transacciones', 'saldoActual'));
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

        $tipos = Tipo::where(function($q) {
                $q->where('usuario_id', Auth::user()->id_usuario)->orWhereNull('usuario_id');
            })->orderBy('nombre_tipo')->get();
        $categorias = CategoriaTransaccion::where(function($q) {
                $q->where('usuario_id', Auth::user()->id_usuario)->orWhereNull('usuario_id');
            })->orderBy('nombre_categoria_transaccion')->get();
        $entidades = EntidadFinanciera::where(function($q) {
                $q->where('usuario_id', Auth::user()->id_usuario)->orWhereNull('usuario_id');
            })->orderBy('nombre_entidad_financiera')->get();
        $proyecciones = ProyeccionFinanciera::where('usuario_id', Auth::id())
            ->orderBy('nombre_proyeccion_financiera')->get();

        return view('transacciones.create', compact('tipos', 'categorias', 'entidades', 'proyecciones'));
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
                'valor_transaccion' => 'required|numeric|min:0',
                'tipo_id' => 'required|exists:tipos,id_tipo',
                'categoria_id' => 'required|exists:categorias_transacciones,id_categoria_transaccion',
                'entidad_financiera_id' => 'required|exists:entidades_financieras,id_entidad_financiera',
                'proyeccion_financiera_id' => 'nullable|exists:proyecciones_financieras,id_proyeccion_financiera',
            ]);

            // Asignar usuario autenticado
            $validated['usuario_id'] = Auth::id();

            Transaccion::create($validated);
            // El Observer actualizará automáticamente el saldo

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
        $transaccion = Transaccion::with(['tipo', 'categoria', 'entidadFinanciera', 'proyeccionFinanciera', 'usuario'])
            ->where('usuario_id', Auth::id())
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

        $transaccion = Transaccion::where('usuario_id', Auth::id())->findOrFail($id);

        $tipos = Tipo::where(function($q) {
                $q->where('usuario_id', Auth::user()->id_usuario)->orWhereNull('usuario_id');
            })->orderBy('nombre_tipo')->get();
        $categorias = CategoriaTransaccion::where(function($q) {
                $q->where('usuario_id', Auth::user()->id_usuario)->orWhereNull('usuario_id');
            })->orderBy('nombre_categoria_transaccion')->get();
        $entidades = EntidadFinanciera::where(function($q) {
                $q->where('usuario_id', Auth::user()->id_usuario)->orWhereNull('usuario_id');
            })->orderBy('nombre_entidad_financiera')->get();
        $proyecciones = ProyeccionFinanciera::where('usuario_id', Auth::id())
            ->orderBy('nombre_proyeccion_financiera')->get();

        return view('transacciones.edit', compact('transaccion', 'tipos', 'categorias', 'entidades', 'proyecciones'));
    }

    /**
     * Actualizar transacción
     */
    public function update(Request $request, $id)
    {
        try {
            $transaccion = Transaccion::where('usuario_id', Auth::id())->findOrFail($id);

            $validated = $request->validate([
                'nombre_transaccion' => 'required|string|max:255',
                'descripcion_transaccion' => 'nullable|string',
                'valor_transaccion' => 'required|numeric|min:0',
                'tipo_id' => 'required|exists:tipos,id_tipo',
                'categoria_id' => 'required|exists:categorias_transacciones,id_categoria_transaccion',
                'entidad_financiera_id' => 'required|exists:entidades_financieras,id_entidad_financiera',
                'proyeccion_financiera_id' => 'nullable|exists:proyecciones_financieras,id_proyeccion_financiera',
            ]);

            $transaccion->update($validated);
            // El Observer actualizará automáticamente el saldo

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
            $transaccion = Transaccion::where('usuario_id', Auth::id())->findOrFail($id);
            $transaccion->delete();
            // El Observer actualizará automáticamente el saldo

            return redirect()->route('transacciones.index')
                ->with('success', 'Transacción eliminada correctamente');
        } catch (\Exception $e) {
            Log::error('Error eliminando transacción: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error eliminando transacción']);
        }
    }

    /**
     * Obtener saldo disponible para un periodo (API/Web)
     * GET /api/transacciones/saldo-disponible?mes=10&anio=2025
     */
    public function getSaldoDisponible(Request $request)
    {
        try {
            $mes = $request->input('mes', now()->month);
            $anio = $request->input('anio', now()->year);

            if (!Auth::check()) {
                return response()->json(['error' => 'Usuario no autenticado'], 401);
            }

            $usuarioId = Auth::id();
            $saldo = SaldoDisponible::obtenerSaldo($usuarioId, $mes, $anio);

            return response()->json([
                'saldo_disponible' => $saldo->saldo_disponible,
                'mes' => $saldo->mes,
                'anio' => $saldo->anio,
                'periodo' => $this->obtenerNombreMes($saldo->mes) . ' ' . $saldo->anio,
            ]);
        } catch (\Exception $e) {
            Log::error('Error obteniendo saldo disponible: ' . $e->getMessage());
            return response()->json(['error' => 'Error obteniendo saldo'], 500);
        }
    }

    /**
     * Recalcular saldo de un periodo específico (API/Web)
     * POST /api/transacciones/recalcular-saldo
     */
    public function recalcularSaldo(Request $request)
    {
        try {
            $validated = $request->validate([
                'mes' => 'required|integer|min:1|max:12',
                'anio' => 'required|integer|min:2020|max:2100',
            ]);

            if (!Auth::check()) {
                return response()->json(['error' => 'Usuario no autenticado'], 401);
            }

            $usuarioId = Auth::id();
            $saldo = SaldoDisponible::obtenerSaldo($usuarioId, $validated['mes'], $validated['anio']);

            return response()->json([
                'message' => 'Saldo recalculado exitosamente',
                'saldo_disponible' => $saldo->saldo_disponible,
                'mes' => $saldo->mes,
                'anio' => $saldo->anio,
            ]);
        } catch (\Exception $e) {
            Log::error('Error recalculando saldo: ' . $e->getMessage());
            return response()->json(['error' => 'Error recalculando saldo'], 500);
        }
    }

    /**
     * Obtener historial de saldos del usuario (API/Web)
     * GET /api/transacciones/historial-saldos?limite=12
     */
    public function getHistorialSaldos(Request $request)
    {
        try {
            $limite = $request->input('limite', 12);

            if (!Auth::check()) {
                return response()->json(['error' => 'Usuario no autenticado'], 401);
            }

            $usuarioId = Auth::id();

            $saldos = SaldoDisponible::where('usuario_id', $usuarioId)
                ->orderBy('anio', 'desc')
                ->orderBy('mes', 'desc')
                ->limit($limite)
                ->get()
                ->map(function ($saldo) {
                    return [
                        'periodo' => $this->obtenerNombreMes($saldo->mes) . ' ' . $saldo->anio,
                        'mes' => $saldo->mes,
                        'anio' => $saldo->anio,
                        'saldo_disponible' => $saldo->saldo_disponible,
                        'fecha_actualizacion' => $saldo->fecha_actualizacion->format('d/m/Y H:i'),
                    ];
                });

            return response()->json($saldos);
        } catch (\Exception $e) {
            Log::error('Error obteniendo historial de saldos: ' . $e->getMessage());
            return response()->json(['error' => 'Error obteniendo historial'], 500);
        }
    }

    /**
     * Obtener nombre del mes en español
     */
    private function obtenerNombreMes($mes)
    {
        $meses = [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
        ];

        return $meses[$mes] ?? 'Desconocido';
    }
}
