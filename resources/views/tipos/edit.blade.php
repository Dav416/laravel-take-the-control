@extends('layouts.app')

@section('title', 'Editar Tipo')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Editar Tipo</h1>
            <a href="{{ route('tipos.index') }}" class="btn btn-secondary">
                ← Volver
            </a>
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
                    <h5 class="mb-0">Información del Tipo</h5>
                    <span class="badge bg-info">ID: {{ $tipo->id_tipo }}</span>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('tipos.update', $tipo->id_tipo) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="nombre_tipo" class="form-label">
                            Nombre del Tipo <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               class="form-control @error('nombre_tipo') is-invalid @enderror"
                               id="nombre_tipo"
                               name="nombre_tipo"
                               value="{{ old('nombre_tipo', $tipo->nombre_tipo) }}"
                               required
                               autofocus>
                        @error('nombre_tipo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="categoria_tipo_id" class="form-label">
                            Categoría <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('categoria_tipo_id') is-invalid @enderror"
                                id="categoria_tipo_id"
                                name="categoria_tipo_id"
                                required>
                            <option value="">Seleccione una categoría</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id_categoria_tipo }}"
                                        {{ old('categoria_tipo_id', $tipo->categoria_tipo_id) == $categoria->id_categoria_tipo ? 'selected' : '' }}>
                                    {{ $categoria->nombre_categoria_tipo }}
                                </option>
                            @endforeach
                        </select>
                        @error('categoria_tipo_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="descripcion_tipo" class="form-label">
                            Descripción (Opcional)
                        </label>
                        <textarea class="form-control @error('descripcion_tipo') is-invalid @enderror"
                                  id="descripcion_tipo"
                                  name="descripcion_tipo"
                                  rows="4">{{ old('descripcion_tipo', $tipo->descripcion_tipo) }}</textarea>
                        @error('descripcion_tipo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Información adicional --}}
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="text-muted small">TRANSACCIONES ASOCIADAS</h6>
                                    <h3 class="mb-0">{{ $tipo->transacciones->count() }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="text-muted small">FECHA DE CREACIÓN</h6>
                                    <h6 class="mb-0">{{ $tipo->fecha_creacion->format('d/m/Y H:i') }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($tipo->transacciones->count() > 0)
                        <div class="alert alert-warning">
                            <strong>⚠️ Atención:</strong> Este tipo tiene {{ $tipo->transacciones->count() }}
                            transacción(es) asociada(s). Los cambios afectarán todas las transacciones que lo usan.
                        </div>
                    @endif

                    <div class="d-flex justify-content-between">
                        <div>
                            @if($tipo->transacciones->count() === 0)
                                <button type="button"
                                        class="btn btn-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEliminar">
                                    🗑️ Eliminar Tipo
                                </button>
                            @else
                                <button type="button"
                                        class="btn btn-secondary"
                                        disabled
                                        title="No se puede eliminar porque tiene transacciones asociadas">
                                    🔒 No se puede eliminar
                                </button>
                            @endif
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('tipos.index') }}"
                               class="btn btn-secondary">
                                Cancelar
                            </a>
                            <button type="submit"
                                    class="btn btn-success">
                                💾 Actualizar Tipo
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
                <p>¿Estás seguro de que deseas eliminar el tipo <strong>"{{ $tipo->nombre_tipo }}"</strong>?</p>
                <p class="text-danger mb-0">Esta acción no se puede deshacer.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="{{ route('tipos.destroy', $tipo->id_tipo) }}"
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
