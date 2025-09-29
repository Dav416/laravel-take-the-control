<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;

Route::get('/', [UsuarioController::class, 'showLoginForm'])->name('login');
Route::get('/dashboard', [UsuarioController::class, 'dashboard'])->name('dashboard');
Route::post('/login', [UsuarioController::class, 'login'])->name('login.post');
Route::post('/logout', [UsuarioController::class, 'logout'])->name('logout');
Route::resource('usuarios', UsuarioController::class);
Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});
