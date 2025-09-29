<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;

/**
 * Rutas públicas
 */
Route::get('/', [UsuarioController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UsuarioController::class, 'login'])->name('login.post');

/**
 * Rutas protegidas con autenticación de sesión (para vistas web)
 */
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [UsuarioController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [UsuarioController::class, 'logout'])->name('logout');
    Route::resource('usuarios', UsuarioController::class);
});
