<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\TransaccionController;

// Rutas de API protegidas con Sanctum
Route::middleware('auth:sanctum')->group(function () {

    // Usuarios API
    Route::get('usuarios', [UsuarioController::class, 'index']);
    Route::post('usuarios', [UsuarioController::class, 'store']);
    Route::get('usuarios/{id}', [UsuarioController::class, 'show']);
    Route::put('usuarios/{id}', [UsuarioController::class, 'update']);
    Route::delete('usuarios/{id}', [UsuarioController::class, 'destroy']);

    // Transacciones API
    Route::get('transacciones', [TransaccionController::class, 'index']);
    Route::post('transacciones', [TransaccionController::class, 'store']);
    Route::get('transacciones/{id}', [TransaccionController::class, 'show']);
    Route::put('transacciones/{id}', [TransaccionController::class, 'update']);
    Route::delete('transacciones/{id}', [TransaccionController::class, 'destroy']);

    // Saldos API
    Route::get('transacciones/saldo-disponible', [TransaccionController::class, 'getSaldoDisponible']);
    Route::post('transacciones/recalcular-saldo', [TransaccionController::class, 'recalcularSaldo']);
    Route::get('transacciones/historial-saldos', [TransaccionController::class, 'getHistorialSaldos']);
});
