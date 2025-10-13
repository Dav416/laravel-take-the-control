<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\TransaccionController;
use App\Http\Controllers\CategoriaTransaccionController;
use App\Http\Controllers\TipoController;
use App\Http\Controllers\EntidadFinancieraController;
use App\Http\Controllers\ProyeccionFinancieraController;
use App\Http\Controllers\CategoriaProyeccionController;

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
    Route::prefix('categorias-transacciones')->name('categorias.')->group(function () {
        Route::resource('/', CategoriaTransaccionController::class)->parameters(['' => 'categoria']);
    });

    // Tipos de Transacciones CRUD
    Route::resource('tipos', TipoController::class);

    // Entidades Financieras CRUD
    Route::resource('entidades', EntidadFinancieraController::class);

    // Categorías de Proyecciones CRUD
    // Route::prefix('categorias-proyecciones')->name('categorias.')->group(function () {
    //     Route::resource('/', CategoriaProyeccionController::class)->parameters(['' => 'categoria']);
    // });

    Route::resource('categorias-proyecciones', CategoriaProyeccionController::class)
        ->names([
            'index' => 'categorias-proyecciones.index',
            'create' => 'categorias-proyecciones.create',
            'store' => 'categorias-proyecciones.store',
            'edit' => 'categorias-proyecciones.edit',
            'update' => 'categorias-proyecciones.update',
            'destroy' => 'categorias-proyecciones.destroy',
        ]);

    // Proyecciones Financieras CRUD
    Route::resource('proyecciones', ProyeccionFinancieraController::class);

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
