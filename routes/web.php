<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;

Route::get('/', [UsuarioController::class, 'showLoginForm'])->name('login');
Route::get('/dashboard', [UsuarioController::class, 'dashboard'])->name('dashboard');
Route::resource('usuarios', UsuarioController::class);
Route::post('/login', [UsuarioController::class, 'login'])->name('login.post');
Route::post('/logout', [UsuarioController::class, 'logout'])->name('logout');
