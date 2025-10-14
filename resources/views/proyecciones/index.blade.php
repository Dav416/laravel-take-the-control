@extends('layouts.app')

@section('title', 'Proyecciones Financieras')

@section('content')
<div class="row align-items-center mb-4">
    <div class="col-12 col-md-6 mb-3 mb-md-0">
        <h1 class="mb-0">
            <span class="badge bg-info me-2" style="font-size: 1.5rem;">🎯</span>
            Proyecciones Financieras
        </h1>
    </div>
    <div class="col-12 col-md-6">
        <div class="d-flex flex-column flex-sm-row gap-2 justify-content-md-end">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                Volver
            </a>
            <a href="{{ route('proyecciones.create') }}" class="btn btn-info text-white">
                + Nueva Proyección
            </a>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        ✓ {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        ✗ {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Estadísticas generales --}}
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-info">
            <div class="card-body text-center">
                <h6 class="text-muted">Total Proyecciones</h6>
                <h3 class="text-info mb-0">{{ $proyecciones->total() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-success">
            <div class="card-body text-center">
                <h6 class="text-muted">Completadas</h6>
                <h3 class="text-success mb-0">
                    {{ $proyecciones->filter(fn($p) => $p->porcentaje >= 100)->count() }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-warning">
            <div class="card-body text-center">
                <h6 class="text-muted">En Progreso</h6>
                <h3 class="text-warning mb-0">
                    {{ $proyecciones->filter(fn($p) => $p->porcentaje > 0 && $p->porcentaje < 100)->count() }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-secondary">
            <div class="card-body text-center">
                <h6 class="text-muted">Sin Iniciar</h6>
                <h3 class="text-secondary mb-0">
                    {{ $proyecciones->filter(fn($p) => $p->porcentaje == 0)->count() }}
                </h3>
            </div>
        </div>
    </div>
</div>

{{-- Listado de proyecciones --}}
<div class="row">
    @forelse($proyecciones as $proyeccion)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm hover-card">
                <div class="card-header bg-{{ $proyeccion->porcentaje >= 100 ? 'success' : ($proyeccion->porcentaje > 0 ? 'info' : 'secondary') }} text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ $proyeccion->nombre_proyeccion_financiera }}</h5>
                        <span class="badge bg-white text-dark">
                            {{ number_format($proyeccion->porcentaje, 1) }}%
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">
                        <strong>Categoría:</strong> {{ $proyeccion->categoriaProyeccion->nombre_categoria_proyeccion }}
                    </p>

                    @if($proyeccion->descripcion_proyeccion_financiera)
                        <p class="text-muted small">{{ Str::limit($proyeccion->descripcion_proyeccion_financiera, 80) }}</p>
                    @endif

                    {{-- Barra de progreso --}}
                    <div class="mb-3">
                        <div class="progress" style="height: 25px;">
                            <div class="progress-bar
                                {{ $proyeccion->porcentaje >= 100 ? 'bg-success' : 'bg-info' }}"
                                role="progressbar"
                                style="width: {{ min($proyeccion->porcentaje, 100) }}%"
                                aria-valuenow="{{ $proyeccion->porcentaje }}"
                                aria-valuemin="0"
                                aria-valuemax="100">
                                <strong>{{ number_format($proyeccion->porcentaje, 1) }}%</strong>
                            </div>
                        </div>
                    </div>

                    {{-- Montos --}}
                    <div class="row text-center mb-3">
                        <div class="col-6">
                            <small class="text-muted d-block">Actual</small>
                            <strong class="text-info">
                                ${{ number_format($proyeccion->progreso_actual, 0, ',', '.') }}
                            </strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Meta</small>
                            <strong class="text-success">
                                ${{ number_format($proyeccion->meta_proyeccion_financiera, 0, ',', '.') }}
                            </strong>
                        </div>
                    </div>

                    {{-- Información adicional --}}
                    <div class="d-flex justify-content-between align-items-center text-muted small mb-3">
                        <span>
                            📊 {{ $proyeccion->transacciones->count() }} transacciones
                        </span>
                        <span>
                            📅 {{ $proyeccion->fecha_creacion->format('d/m/Y') }}
                        </span>
                    </div>

                    {{-- Acciones --}}
                    <div class="btn-group w-100" role="group">
                        <a href="{{ route('proyecciones.show', $proyeccion->id_proyeccion_financiera) }}"
                           class="btn btn-sm btn-outline-info">
                            Ver Detalles
                        </a>
                        <a href="{{ route('proyecciones.edit', $proyeccion->id_proyeccion_financiera) }}"
                           class="btn btn-sm btn-outline-warning">
                            Editar
                        </a>
                        @if($proyeccion->transacciones->count() === 0)
                            <form action="{{ route('proyecciones.destroy', $proyeccion->id_proyeccion_financiera) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('¿Estás seguro de eliminar esta proyección?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    Eliminar
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <div style="font-size: 4rem;">🎯</div>
                    <h4 class="mt-3">No tienes proyecciones financieras</h4>
                    <p class="text-muted">Crea tu primera proyección para comenzar a alcanzar tus metas financieras</p>
                    <a href="{{ route('proyecciones.create') }}" class="btn btn-info mt-3">
                        + Crear Primera Proyección
                    </a>
                </div>
            </div>
        </div>
    @endforelse
</div>

@if($proyecciones->hasPages())
<div class="mt-4">
    {{ $proyecciones->links('pagination::bootstrap-5') }}
</div>
@endif

<style>
.hover-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.15) !important;
}
</style>
@endsection
