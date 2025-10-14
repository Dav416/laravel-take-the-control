@extends('layouts.app')

@section('title', 'Editar Categoría de Proyección')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Editar Categoría</h1>
        </div>

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <strong>Error:</strong>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Información de la Categoría</h5>
                    <span class="badge bg-info">ID: {{ $categoria->id_categoria_proyeccion }}</span>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('categorias-proyecciones.update', $categoria->id_categoria_proyeccion) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="nombre_categoria_proyeccion" class="form-label">
                            Nombre de la Categoría <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               class="form-control @error('nombre_categoria_proyeccion') is-invalid @enderror"
                               id="nombre_categoria_proyeccion"
                               name="nombre_categoria_proyeccion"
                               value="{{ old('nombre_categoria_proyeccion', $categoria->nombre_categoria_proyeccion) }}"
                               required
                               autofocus>
                        @error('nombre_categoria_proyeccion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="descripcion_categoria_proyeccion" class="form-label">
                            Descripción (Opcional)
                        </label>
                        <textarea class="form-control @error('descripcion_categoria_proyeccion') is-invalid @enderror"
                                  id="descripcion_categoria_proyeccion"
                                  name="descripcion_categoria_proyeccion"
                                  rows="4">{{ old('descripcion_categoria_proyeccion', $categoria->descripcion_categoria_proyeccion) }}</textarea>
                        @error('descripcion_categoria_proyeccion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Información adicional --}}
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="text-muted small">PROYECCIONES ASOCIADAS</h6>
                                    <h3 class="mb-0">{{ $categoria->proyecciones->count() }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="text-muted small">FECHA DE CREACIÓN</h6>
                                    <h6 class="mb-0">{{ $categoria->fecha_creacion->format('d/m/Y H:i') }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($categoria->proyecciones->count() > 0)
                        <div class="alert alert-warning">
                            <strong>⚠️ Atención:</strong> Esta categoría tiene {{ $categoria->proyecciones->count() }}
                            proyección(es) asociada(s). Los cambios afectarán todas las proyecciones que la usan.
                        </div>
                    @endif

                    <div class="d-flex justify-content-between">
                        <div>
                            @if($categoria->proyecciones->count() === 0)
                                <button type="button"
                                        class="btn btn-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEliminar">
                                    🗑️ Eliminar Categoría
                                </button>
                            @else
                                <button type="button"
                                        class="btn btn-secondary"
                                        disabled
                                        title="No se puede eliminar porque tiene proyecciones asociadas">
                                    🔒 No se puede eliminar
                                </button>
                            @endif
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('categorias-proyecciones.index') }}"
                               class="btn btn-secondary">
                                Cancelar
                            </a>
                            <button type="submit"
                                    class="btn btn-warning">
                                Actualizar Categoría
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal de confirmación para eliminar --}}
<div class="modal fade" id="modalEliminar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Confirmar Eliminación</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas eliminar la categoría <strong>"{{ $categoria->nombre_categoria_proyeccion }}"</strong>?</p>
                <p class="text-danger mb-0">Esta acción no se puede deshacer.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="{{ route('categorias-proyecciones.destroy', $categoria->id_categoria_proyeccion) }}"
                      method="POST"
                      class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        Sí, eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
