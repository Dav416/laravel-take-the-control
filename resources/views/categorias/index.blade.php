@extends('layouts.app')

@section('title', 'Categorías de Transacciones')

@section('content')
<div class="row align-items-center mb-4">
    <div class="col-12 col-md-6 mb-3 mb-md-0">
        <h1 class="mb-0">
            <span class="badge bg-secondary me-2" style="font-size: 1.5rem;">🏷️</span>
            Categorías de Transacciones
        </h1>
    </div>
    <div class="col-12 col-md-6">
        <div class="d-flex flex-column flex-sm-row gap-2 justify-content-md-end">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                Volver
            </a>
            <a href="{{ route('categorias.create') }}" class="btn btn-primary">
                + Nueva Categoría
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

{{-- Estadísticas --}}
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-success">
            <div class="card-body text-center">
                <h6 class="text-muted">Total Categorías</h6>
                <h3 class="text-success mb-0">{{ $categorias->total() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-info">
            <div class="card-body text-center">
                <h6 class="text-muted">Más Usada</h6>
                <h3 class="text-info mb-0">
                    {{ $categorias->sortByDesc(fn($c) => $c->transacciones->count())->first()->nombre_categoria_transaccion ?? 'N/A' }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-warning">
            <div class="card-body text-center">
                <h6 class="text-muted">En Uso</h6>
                <h3 class="text-warning mb-0">
                    {{ $categorias->filter(fn($c) => $c->transacciones->count() > 0)->count() }}
                </h3>
            </div>
        </div>
    </div>
</div>

{{-- Tabla de categorías --}}
<div class="card shadow-sm">
    <div class="card-header bg-white">
        <div class="row align-items-center">
            <div class="col">
                <h5 class="mb-0">Listado de Categorías</h5>
            </div>
            <div class="col-auto">
                <span class="badge bg-secondary">{{ $categorias->total() }} registros</span>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th width="80">ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th width="120" class="text-center">Transacciones</th>
                        <th width="150">Fecha Creación</th>
                        <th width="200" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($categorias as $categoria)
                    <tr>
                        <td class="fw-bold">{{ $categoria->id_categoria_transaccion }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-secondary me-2" style="font-size: 1.2rem;">🏷️</span>
                                <span class="fw-semibold">{{ $categoria->nombre_categoria_transaccion }}</span>
                            </div>
                        </td>
                        <td>
                            <small class="text-muted">
                                {{ Str::limit($categoria->descripcion_categoria_transaccion, 50) ?? 'Sin descripción' }}
                            </small>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-info">
                                {{ $categoria->transacciones->count() }}
                            </span>
                        </td>
                        <td>
                            <small class="text-muted">
                                {{ $categoria->fecha_creacion->format('d/m/Y') }}
                            </small>
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                @if($categoria->usuario_id)
                                    <a href="{{ route('categorias.edit', $categoria->id_categoria_transaccion) }}"
                                       class="btn btn-sm btn-warning"
                                       title="Editar">
                                        Editar
                                    </a>
                                @else
                                    <button type="button"
                                            class="btn btn-sm btn-secondary"
                                            disabled
                                            title="No se puede editar registros por defecto del sistema">
                                        📝
                                    </button>
                                @endif
                                @if($categoria->usuario_id && $categoria->transacciones->count() === 0)
                                    <form action="{{ route('categorias.destroy', $categoria->id_categoria_transaccion) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('¿Estás seguro de eliminar esta categoría?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-danger"
                                                title="Eliminar">
                                            Eliminar
                                        </button>
                                    </form>
                                @else
                                    <button type="button"
                                            class="btn btn-sm btn-secondary"
                                            disabled
                                            title="{{ $categoria->usuario_id ? 'No se puede eliminar (tiene transacciones asociadas)' : 'No se puede eliminar registros por defecto del sistema' }}">
                                        🔒
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <div style="font-size: 3rem;">📭</div>
                            <p class="mt-2 mb-0">No hay categorías registradas</p>
                            <a href="{{ route('categorias.create') }}" class="btn btn-success mt-3">
                                + Crear primera categoría
                            </a>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($categorias->hasPages())
    <div class="card-footer bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <div class="text-muted small">
                Mostrando {{ $categorias->firstItem() }} - {{ $categorias->lastItem() }} de {{ $categorias->total() }}
            </div>
            <div>
                {{ $categorias->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
    @endif
</div>

<style>
.table tbody tr:hover {
    background-color: #f8f9fa;
}
</style>
@endsection
