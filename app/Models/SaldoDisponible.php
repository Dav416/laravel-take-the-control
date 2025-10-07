<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaldoDisponible extends Model
{
    protected $table = 'saldos_disponibles';
    protected $primaryKey = 'id_saldo';
    public $timestamps = true;

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';

    protected $fillable = [
        'usuario_id',
        'mes',
        'anio',
        'saldo_disponible',
    ];

    protected $casts = [
        'saldo_disponible' => 'decimal:2',
        'mes' => 'integer',
        'anio' => 'integer',
        'fecha_creacion' => 'datetime',
        'fecha_actualizacion' => 'datetime',
    ];

    /**
     * Obtener la clave de ruta para el model binding
     */
    public function getRouteKeyName()
    {
        return 'id_saldo';
    }


    /**
     * Relación con Usuario
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id_usuario');
    }

    /**
     * Recalcular saldo basado en transacciones del periodo
     *
     * Lógica:
     * - Ingreso sin proyección: SUMA
     * - Ingreso con proyección: RESTA (dinero comprometido)
     * - Egreso sin proyección: RESTA
     * - Egreso con proyección: SUMA (liberación de dinero comprometido)
     */
    public function recalcular()
    {
        $transacciones = Transaccion::where('usuario_id', $this->usuario_id)
            ->whereYear('fecha_creacion', $this->anio)
            ->whereMonth('fecha_creacion', $this->mes)
            ->with(['tipo'])
            ->get();

        $saldo = 0;

        foreach ($transacciones as $trans) {
            $esIngreso = $trans->tipo->nombre_tipo === 'Ingreso';
            $esProyeccion = !is_null($trans->proyeccion_financiera_id);

            if ($esIngreso && !$esProyeccion) {
                // Ingreso normal: suma al saldo
                $saldo += $trans->valor_transaccion;
            } elseif ($esIngreso && $esProyeccion) {
                // Ingreso para proyección: resta (dinero comprometido)
                $saldo -= $trans->valor_transaccion;
            } elseif (!$esIngreso && !$esProyeccion) {
                // Egreso normal: resta del saldo
                $saldo -= $trans->valor_transaccion;
            } elseif (!$esIngreso && $esProyeccion) {
                // Egreso de proyección: suma (liberación de comprometido)
                $saldo += $trans->valor_transaccion;
            }
        }

        // No permitir saldo negativo
        $this->saldo_disponible = max(0, $saldo);
        $this->save();

        return $this->saldo_disponible;
    }

    /**
     * Obtener o crear saldo para un periodo específico
     */
    public static function obtenerSaldo($usuarioId, $mes = null, $anio = null)
    {
        $mes = $mes ?? now()->month;
        $anio = $anio ?? now()->year;

        $saldo = self::firstOrCreate([
            'usuario_id' => $usuarioId,
            'mes' => $mes,
            'anio' => $anio,
        ]);

        $saldo->recalcular();

        return $saldo;
    }
}
