<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\TransaccionController;

Route::get('usuarios', [UsuarioController::class, 'index']);
Route::post('usuarios', [UsuarioController::class, 'store']);
Route::get('usuarios/{id}', [UsuarioController::class, 'show']);
Route::put('usuarios/{id}', [UsuarioController::class, 'update']);
Route::delete('usuarios/{id}', [UsuarioController::class, 'destroy']);

Route::get('transacciones', [TransaccionController::class, 'index']);
Route::post('transacciones', [TransaccionController::class, 'store']);
Route::get('transacciones/{id}', [TransaccionController::class, 'show']);
Route::put('transacciones/{id}', [TransaccionController::class, 'update']);
Route::delete('transacciones/{id}', [TransaccionController::class, 'destroy']);
