@extends('layouts.app')

@section('title', 'Transacciones')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Transacciones</h1>
    <div>
        <a href="{{ route('transacciones.create') }}" class="btn btn-primary">
            + Nueva Transacción
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Valor</th>
                        <th>Categoría</th>
                        <th>Entidad</th>
                        <th>Proyección</th>
                        <th>Fecha</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transacciones as $transaccion)
                        <tr>
                            <td>{{ $transaccion->id_transaccion }}</td>
                            <td>{{ $transaccion->nombre_transaccion }}</td>
                            <td>{{ Str::limit($transaccion->descripcion_transaccion, 40) }}</td>
                            <td class="fw-bold">${{ number_format($transaccion->valor_transaccion, 0, ',', '.') }}</td>
                            <td>{{ $transaccion->categoria->nombre_categoria_transaccion ?? 'N/A' }}</td>
                            <td>{{ $transaccion->entidadFinanciera->nombre_entidad_financiera ?? 'N/A' }}</td>
                            <td>{{ $transaccion->proyeccionFinanciera->nombre_proyeccion_financiera ?? '-' }}</td>
                            <td>{{ $transaccion->fecha_creacion->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <a href="{{ route('transacciones.edit', $transaccion->id_transaccion) }}"
                                   class="btn btn-sm btn-warning">
                                    Editar
                                </a>
                                <form action="{{ route('transacciones.destroy', $transaccion->id_transaccion) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('¿Estás seguro de eliminar esta transacción?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                No hay transacciones registradas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    {{ $transacciones->links('pagination::bootstrap-5') }}
</div>

    <form action="{{ route('logout') }}" method="POST" class="mt-3">
        @csrf
        <button type="submit" class="btn btn-secondary">Cerrar sesión</button>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">↩ Volver</a>
    </form>
@endsection
