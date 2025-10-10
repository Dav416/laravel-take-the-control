@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container py-5">
    <!-- Saludo -->
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold text-dark">
            ¡Bienvenido, {{ Auth::user()->nombre_usuario }}! 🎉
        </h1>
        <p class="lead text-muted mt-3">
            Este es tu panel principal. Selecciona una opción para comenzar.
        </p>
    </div>

    <!-- Accesos rápidos -->
    <div class="row g-4 justify-content-center">
        <!-- Usuarios -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm border-0 hover-card">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <span style="font-size: 3rem;">👥</span>
                    </div>
                    <h3 class="card-title h4 mb-3">
                        Gestión de Usuarios
                    </h3>
                    <p class="card-text text-muted mb-4">
                        Administra los usuarios registrados en el sistema.
                    </p>
                    <a href="{{ route('usuarios.index') }}" class="btn btn-primary btn-lg w-100">
                        Ir a Usuarios
                    </a>
                </div>
            </div>
        </div>

        <!-- Transacciones -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm border-0 hover-card">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <span style="font-size: 3rem;">💰</span>
                    </div>
                    <h3 class="card-title h4 mb-3">
                        Transacciones
                    </h3>
                    <p class="card-text text-muted mb-4">
                        Revisa y gestiona las transacciones registradas.
                    </p>
                    <a href="{{ route('transacciones.index') }}" class="btn btn-success btn-lg w-100">
                        Ir a Transacciones
                    </a>
                </div>
            </div>
        </div>

        <!-- Categorías -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm border-0 hover-card">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <span style="font-size: 3rem;">🏷️</span>
                    </div>
                    <h3 class="card-title h4 mb-3">
                        Categorías
                    </h3>
                    <p class="card-text text-muted mb-4">
                        Organiza tus transacciones con categorías personalizadas.
                    </p>
                    <a href="{{ route('categorias.index') }}" class="btn btn-warning btn-lg w-100">
                        Ir a Categorías
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas rápidas (opcional) -->
    @if(Auth::check())
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="text-center mb-4">Resumen Rápido</h3>
        </div>
        <div class="col-md-4">
            <div class="card text-center border-primary">
                <div class="card-body">
                    <h5 class="text-primary">Total Usuarios</h5>
                    <p class="display-6 mb-0">{{ \App\Models\Usuario::count() }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center border-success">
                <div class="card-body">
                    <h5 class="text-success">Mis Transacciones</h5>
                    <p class="display-6 mb-0">{{ \App\Models\Transaccion::where('usuario_id', Auth::user()->id_usuario)->count() }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center border-info">
                <div class="card-body">
                    <h5 class="text-info">Saldo Actual</h5>
                    <p class="display-6 mb-0">
                        ${{ number_format(\App\Models\SaldoDisponible::obtenerSaldo(Auth::user()->id_usuario)->saldo_disponible ?? 0, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<style>
.hover-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.hover-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
}
</style>
@endsection
