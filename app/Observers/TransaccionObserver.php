<?php

namespace App\Observers;

use App\Models\Transaccion;
use App\Models\SaldoDisponible;

class TransaccionObserver
{

    public function created(Transaccion $transaccion): void
    {
        $this->actualizarSaldo($transaccion);
    }

    public function updated(Transaccion $transaccion): void
    {
        $this->actualizarSaldo($transaccion);

        // Si cambió la fecha, actualizar también el periodo anterior
        if ($transaccion->wasChanged('fecha_creacion')) {
            $fechaOriginal = $transaccion->getOriginal('fecha_creacion');
            $this->actualizarSaldoPorFecha($transaccion->usuario_id, $fechaOriginal);
        }
    }

    public function deleted(Transaccion $transaccion): void
    {
        $this->actualizarSaldo($transaccion);
    }

    public function restored(Transaccion $transaccion): void
    {
        $this->actualizarSaldo($transaccion);
    }

    /**
     * Actualizar el saldo disponible del periodo de la transacción
     */
    private function actualizarSaldo(Transaccion $transaccion): void
    {
        $fecha = $transaccion->fecha_creacion;

        $saldo = SaldoDisponible::firstOrCreate([
            'usuario_id' => $transaccion->usuario_id,
            'mes' => $fecha->month,
            'anio' => $fecha->year,
        ]);

        $saldo->recalcular();
    }

    /**
     * Actualizar saldo por fecha específica
     */
    private function actualizarSaldoPorFecha($usuarioId, $fecha): void
    {
        $fechaCarbon = \Carbon\Carbon::parse($fecha);

        $saldo = SaldoDisponible::firstOrCreate([
            'usuario_id' => $usuarioId,
            'mes' => $fechaCarbon->month,
            'anio' => $fechaCarbon->year,
        ]);

        $saldo->recalcular();
    }
}
