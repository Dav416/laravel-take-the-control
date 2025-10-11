<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\TransaccionController;
use App\Http\Controllers\CategoriaTransaccionController;
use App\Http\Controllers\TipoController;
use App\Models\EntidadFinanciera;

/**
 * Rutas públicas
 */
Route::get('/', [UsuarioController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UsuarioController::class, 'login'])->name('login.post');

/**
 * Rutas protegidas con autenticación de sesión
 */
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [UsuarioController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [UsuarioController::class, 'logout'])->name('logout');

    // Usuarios CRUD
    Route::resource('usuarios', UsuarioController::class);

    // Categorías de Transacciones CRUD
    Route::resource('categorias-transacciones', CategoriaTransaccionController::class)
        ->names([
            'index' => 'categorias.index',
            'create' => 'categorias.create',
            'store' => 'categorias.store',
            'show' => 'categorias.show',
            'edit' => 'categorias.edit',
            'update' => 'categorias.update',
            'destroy' => 'categorias.destroy',
        ]);

    // Tipos de Transacciones CRUD
    Route::resource('tipos', TipoController::class)
        ->names([
            'index' => 'tipos.index',
            'create' => 'tipos.create',
            'store' => 'tipos.store',
            'show' => 'tipos.show',
            'edit' => 'tipos.edit',
            'update' => 'tipos.update',
            'destroy' => 'tipos.destroy',
        ]);

    // Entidades Financieras de Transacciones CRUD
    Route::resource('entidades', EntidadFinanciera::class)
        ->names([
            'index' => 'entidades.index',
            'create' => 'entidades.create',
            'store' => 'entidades.store',
            'show' => 'entidades.show',
            'edit' => 'entidades.edit',
            'update' => 'entidades.update',
            'destroy' => 'entidades.destroy',
        ]);

    // Rutas especiales de saldo (ANTES del resource de transacciones)
    Route::get('transacciones/saldo-disponible', [TransaccionController::class, 'getSaldoDisponible'])
        ->name('transacciones.saldo-disponible');
    Route::post('transacciones/recalcular-saldo', [TransaccionController::class, 'recalcularSaldo'])
        ->name('transacciones.recalcular-saldo');
    Route::get('transacciones/historial-saldos', [TransaccionController::class, 'getHistorialSaldos'])
        ->name('transacciones.historial-saldos');

    // Transacciones CRUD (DESPUÉS de las rutas especiales)
    Route::resource('transacciones', TransaccionController::class);
});
