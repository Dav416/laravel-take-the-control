@extends('layouts.app')

@section('title', 'Detalle de Proyección')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>{{ $proyeccion->nombre_proyeccion_financiera }}</h1>
    <div class="d-flex gap-2">
        <a href="{{ route('proyecciones.index') }}" class="btn btn-secondary">
            ← Volver
        </a>
        <a href="{{ route('proyecciones.edit', $proyeccion->id_proyeccion_financiera) }}" class="btn btn-warning">
            Editar
        </a>
    </div>
</div>

{{-- Progreso general --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm border-{{ $proyeccion->porcentaje >= 100 ? 'success' : 'info' }}">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h5 class="text-muted">Progreso de la Meta</h5>
                        <div class="progress mb-3" style="height: 35px;">
                            <div class="progress-bar
                                {{ $proyeccion->porcentaje >= 100 ? 'bg-success' : 'bg-info' }}"
                                role="progressbar"
                                style="width: {{ min($proyeccion->porcentaje, 100) }}%">
                                <strong style="font-size: 1.1rem;">{{ number_format($proyeccion->porcentaje, 1) }}%</strong>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-4">
                                <small class="text-muted d-block">Actual</small>
                                <h4 class="text-info mb-0">
                                    ${{ number_format($proyeccion->progreso_actual, 0, ',', '.') }}
                                </h4>
                            </div>
                            <div class="col-4">
                                <small class="text-muted d-block">Meta</small>
                                <h4 class="text-success mb-0">
                                    ${{ number_format($proyeccion->meta_proyeccion_financiera, 0, ',', '.') }}
                                </h4>
                            </div>
                            <div class="col-4">
                                <small class="text-muted d-block">Faltante</small>
                                <h4 class="text-warning mb-0">
                                    ${{ number_format(max(0, $proyeccion->meta_proyeccion_financiera - $proyeccion->progreso_actual), 0, ',', '.') }}
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div style="font-size: 5rem;">
                            @if($proyeccion->porcentaje >= 100)
                                🎉
                            @elseif($proyeccion->porcentaje >= 75)
                                🎯
                            @elseif($proyeccion->porcentaje >= 50)
                                📈
                            @elseif($proyeccion->porcentaje > 0)
                                🌱
                            @else
                                🎬
                            @endif
                        </div>
                        @if($proyeccion->porcentaje >= 100)
                            <h5 class="text-success">¡Meta Alcanzada!</h5>
                        @elseif($proyeccion->porcentaje >= 75)
                            <h5 class="text-info">Casi lo logras</h5>
                        @elseif($proyeccion->porcentaje >= 50)
                            <h5 class="text-warning">A medio camino</h5>
                        @elseif($proyeccion->porcentaje > 0)
                            <h5 class="text-primary">¡Buen comienzo!</h5>
                        @else
                            <h5 class="text-muted">Listo para empezar</h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Información de la proyección --}}
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-light">
                <h6 class="mb-0">📋 Información General</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td class="text-muted">Categoría:</td>
                        <td><strong>{{ $proyeccion->categoriaProyeccion->nombre_categoria_proyeccion }}</strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Descripción:</td>
                        <td>{{ $proyeccion->descripcion_proyeccion_financiera ?? 'Sin descripción' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Fecha creación:</td>
                        <td>{{ $proyeccion->fecha_creacion->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Última actualización:</td>
                        <td>{{ $proyeccion->fecha_actualizacion->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-light">
                <h6 class="mb-0">📊 Estadísticas</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td class="text-muted">Total transacciones:</td>
                        <td><strong>{{ $proyeccion->transacciones->count() }}</strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Ingresos:</td>
                        <td class="text-success">
                            <strong>
                                {{ $proyeccion->transacciones->filter(fn($t) => $t->tipo->categoria->nombre_categoria_tipo === 'Ingreso')->count() }}
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Egresos:</td>
                        <td class="text-danger">
                            <strong>
                                {{ $proyeccion->transacciones->filter(fn($t) => $t->tipo->categoria->nombre_categoria_tipo === 'Egreso')->count() }}
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Estado:</td>
                        <td>
                            @if($proyeccion->porcentaje >= 100)
                                <span class="badge bg-success">Completada</span>
                            @elseif($proyeccion->porcentaje > 0)
                                <span class="badge bg-info">En progreso</span>
                            @else
                                <span class="badge bg-secondary">Sin iniciar</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Lista de transacciones --}}
<div class="card">
    <div class="card-header bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">💰 Transacciones Asociadas</h5>
            <span class="badge bg-secondary">{{ $proyeccion->transacciones->count() }}</span>
        </div>
    </div>
    <div class="card-body">
        @if($proyeccion->transacciones->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Fecha</th>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th class="text-end">Valor</th>
                            <th class="text-center">Impacto</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($proyeccion->transacciones->sortByDesc('fecha_creacion') as $transaccion)
                            @php
                                $esIngreso = $transaccion->tipo->categoria->nombre_categoria_tipo === 'Ingreso';
                            @endphp
                            <tr>
                                <td>{{ $transaccion->fecha_creacion->format('d/m/Y') }}</td>
                                <td>{{ $transaccion->nombre_transaccion }}</td>
                                <td>
                                    <span class="badge bg-{{ $esIngreso ? 'success' : 'danger' }}">
                                        {{ $transaccion->tipo->nombre_tipo }}
                                    </span>
                                </td>
                                <td class="text-end fw-bold">
                                    ${{ number_format($transaccion->valor_transaccion, 0, ',', '.') }}
                                </td>
                                <td class="text-center">
                                    @if($esIngreso)
                                        <span class="text-success">⬆️ +{{ number_format($transaccion->valor_transaccion, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-danger">⬇️ -{{ number_format($transaccion->valor_transaccion, 0, ',', '.') }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <div style="font-size: 3rem;">📭</div>
                <p class="text-muted mt-3">No hay transacciones asociadas a esta proyección</p>
                <a href="{{ route('transacciones.create') }}" class="btn btn-primary">
                    + Crear Transacción
                </a>
            </div>
        @endif
    </div>
</div>

<div class="mt-4">
    <a href="{{ route('proyecciones.index') }}" class="btn btn-secondary">
        ← Volver al Listado
    </a>
</div>
@endsection
