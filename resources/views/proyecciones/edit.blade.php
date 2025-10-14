@extends('layouts.app')

@section('title', 'Editar Proyección')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Editar Proyección</h1>
            <a href="{{ route('proyecciones.index') }}" class="btn btn-secondary">
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
                    <h5 class="mb-0">Información de la Proyección</h5>
                    <span class="badge bg-info">ID: {{ $proyeccion->id_proyeccion_financiera }}</span>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('proyecciones.update', $proyeccion->id_proyeccion_financiera) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="nombre_proyeccion_financiera" class="form-label">
                            Nombre de la Proyección <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               class="form-control @error('nombre_proyeccion_financiera') is-invalid @enderror"
                               id="nombre_proyeccion_financiera"
                               name="nombre_proyeccion_financiera"
                               value="{{ old('nombre_proyeccion_financiera', $proyeccion->nombre_proyeccion_financiera) }}"
                               required
                               autofocus>
                        @error('nombre_proyeccion_financiera')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="descripcion_proyeccion_financiera" class="form-label">
                            Descripción (Opcional)
                        </label>
                        <textarea class="form-control @error('descripcion_proyeccion_financiera') is-invalid @enderror"
                                  id="descripcion_proyeccion_financiera"
                                  name="descripcion_proyeccion_financiera"
                                  rows="3">{{ old('descripcion_proyeccion_financiera', $proyeccion->descripcion_proyeccion_financiera) }}</textarea>
                        @error('descripcion_proyeccion_financiera')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="meta_proyeccion_financiera" class="form-label">
                                Meta (COP) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number"
                                       class="form-control @error('meta_proyeccion_financiera') is-invalid @enderror"
                                       id="meta_proyeccion_financiera"
                                       name="meta_proyeccion_financiera"
                                       value="{{ old('meta_proyeccion_financiera', $proyeccion->meta_proyeccion_financiera) }}"
                                       step="0.01"
                                       min="0"
                                       required>
                                @error('meta_proyeccion_financiera')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="categoria_id" class="form-label">
                                Categoría <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('categoria_id') is-invalid @enderror"
                                    id="categoria_id"
                                    name="categoria_id"
                                    required>
                                <option value="">Seleccione una categoría</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id_categoria_proyeccion }}"
                                            {{ old('categoria_id', $proyeccion->categoria_id) == $categoria->id_categoria_proyeccion ? 'selected' : '' }}>
                                        {{ $categoria->nombre_categoria_proyeccion }}
                                    </option>
                                @endforeach
                            </select>
                            @error('categoria_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Información adicional --}}
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="text-muted small">TRANSACCIONES ASOCIADAS</h6>
                                    <h3 class="mb-0">{{ $proyeccion->transacciones->count() }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="text-muted small">FECHA DE CREACIÓN</h6>
                                    <h6 class="mb-0">{{ $proyeccion->fecha_creacion->format('d/m/Y H:i') }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($proyeccion->transacciones->count() > 0)
                        <div class="alert alert-warning">
                            <strong>⚠️ Atención:</strong> Esta proyección tiene {{ $proyeccion->transacciones->count() }}
                            transacción(es) asociada(s). Cambiar la meta afectará el cálculo del porcentaje de progreso.
                        </div>
                    @endif

                    <div class="d-flex justify-content-between">
                        <div>
                            @if($proyeccion->transacciones->count() === 0)
                                <button type="button"
                                        class="btn btn-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEliminar">
                                    🗑️ Eliminar Proyección
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
                            <a href="{{ route('proyecciones.index') }}"
                               class="btn btn-secondary">
                                Cancelar
                            </a>
                            <button type="submit"
                                    class="btn btn-info">
                                💾 Actualizar Proyección
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
                <p>¿Estás seguro de que deseas eliminar la proyección <strong>"{{ $proyeccion->nombre_proyeccion_financiera }}"</strong>?</p>
                <p class="text-danger mb-0">Esta acción no se puede deshacer.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="{{ route('proyecciones.destroy', $proyeccion->id_proyeccion_financiera) }}"
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
