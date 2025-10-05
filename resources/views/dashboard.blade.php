@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-10">
    <!-- Saludo -->
    <div class="mb-10 text-center">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">
            ¡Bienvenido, {{ Auth::user()->name }}! 🎉
        </h1>
        <p class="text-gray-600 dark:text-gray-300 mt-2">
            Este es tu panel principal. Selecciona una opción para comenzar.
        </p>
    </div>

    <!-- Accesos rápidos -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
        <!-- Usuarios -->
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6 hover:scale-105 transition-transform">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">
                👤 Gestión de Usuarios
            </h2>
            <p class="text-gray-600 dark:text-gray-300 mb-6">
                Administra los usuarios registrados en el sistema.
            </p>
            <a href="{{ route('usuarios.index') }}" class="btn btn-primary btn-lg">
                Ir a Usuarios
            </a>
        </div>

        <!-- Transacciones -->
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6 hover:scale-105 transition-transform">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">
                💰 Transacciones
            </h2>
            <p class="text-gray-600 dark:text-gray-300 mb-6">
                Revisa y gestiona las transacciones registradas.
            </p>

            <a href="{{ route('transacciones.index') }}" class="btn btn-primary btn-lg">
                Ir a Transacciones
            </a>
        </div>
    </div>
</div>
@endsection
