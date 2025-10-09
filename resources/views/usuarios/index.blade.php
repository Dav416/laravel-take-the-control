@extends('layouts.app')

@section('title', 'Usuarios')

@section('content')
<div class="row align-items-center mb-4">
    <div class="col-12 col-md-6 mb-3 mb-md-0">
        <h1 class="mb-0">
            Gestión de Usuarios
        </h1>
    </div>
    <div class="col-12 col-md-6 col-xs-4">
        <div class="d-flex flex-column flex-sm-row gap-2 justify-content-md-end">
            <a href="{{ route('dashboard') }}" class="btn btn-danger">
                Volver
            </a>

            <a href="{{ route('usuarios.create') }}" class="btn btn-primary">
                + Nuevo Usuario
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

{{-- Tarjeta de estadísticas --}}
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-primary">
            <div class="card-body text-center">
                <h6 class="text-muted">Total Usuarios</h6>
                <h3 class="text-primary mb-0">{{ $usuarios->count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-success">
            <div class="card-body text-center">
                <h6 class="text-muted">Usuarios Activos</h6>
                <h3 class="text-success mb-0">{{ $usuarios->count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-info">
            <div class="card-body text-center">
                <h6 class="text-muted">Tu Cuenta</h6>
                <h3 class="text-info mb-0">{{ Auth::user()->nombre_cuenta_usuario }}</h3>
            </div>
        </div>
    </div>
</div>

{{-- Tabla de usuarios --}}
<div class="card shadow-sm mb-4">
    <div class="card-header bg-white">
        <div class="row align-items-center">
            <div class="col">
                <h5 class="mb-0">Listado de Usuarios</h5>
            </div>
            <div class="col-auto">
                <span class="badge bg-secondary">{{ $usuarios->count() }} registros</span>
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
                        <th>Usuario</th>
                        <th>Correo</th>
                        <th width="150">Fecha Registro</th>
                        <th width="200" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($usuarios as $usuario)
                    <tr>
                        <td class="fw-bold">{{ $usuario->id_usuario }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle bg-primary text-white me-2">
                                    {{ strtoupper(substr($usuario->nombre_usuario, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $usuario->nombre_usuario }}</div>
                                    @if($usuario->id_usuario === Auth::user()->id_usuario)
                                        <span class="badge bg-info" style="font-size: 0.7rem;">Tú</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <code class="bg-light px-2 py-1 rounded">{{ $usuario->nombre_cuenta_usuario }}</code>
                        </td>
                        <td>
                            {{ $usuario->correo_usuario }}
                        </td>
                        <td>
                            <small class="text-muted">
                                {{ $usuario->fecha_creacion->format('d/m/Y') }}
                            </small>
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('usuarios.edit', $usuario->id_usuario) }}"
                                   class="btn btn-sm btn-warning"
                                   title="Editar">
                                    Editar
                                </a>
                                @if($usuario->id_usuario !== Auth::user()->id_usuario)
                                    <form action="{{ route('usuarios.destroy', $usuario->id_usuario) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('¿Estás seguro de eliminar a {{ $usuario->nombre_usuario }}?')">
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
                                            title="No puedes eliminarte a ti mismo">
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
                            <p class="mt-2 mb-0">No hay usuarios registrados</p>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="p-2">
        {{ $usuarios->links('pagination::bootstrap-5') }}
    </div>
</div>
<style>
.avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1.1rem;
}

.table tbody tr:hover {
    background-color: #f8f9fa;
}

.btn-group .btn {
    border-radius: 0;
}

.btn-group .btn:first-child {
    border-top-left-radius: 0.25rem;
    border-bottom-left-radius: 0.25rem;
}

.btn-group .btn:last-child {
    border-top-right-radius: 0.25rem;
    border-bottom-right-radius: 0.25rem;
}

code {
    font-size: 0.875rem;
}
</style>
@endsection
