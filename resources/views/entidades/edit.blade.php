@extends('layouts.app')

@section('title', 'Editar Entidad')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Editar Entidad Financiera</h1>
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
                    <h5 class="mb-0">Información de la Entidad</h5>
                    <span class="badge bg-info">ID: {{ $entidad->id_entidad_financiera }}</span>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('entidades.update', $entidad->id_entidad_financiera) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="nombre_entidad_financiera" class="form-label">
                            Nombre de la Entidad <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               class="form-control @error('nombre_entidad_financiera') is-invalid @enderror"
                               id="nombre_entidad_financiera"
                               name="nombre_entidad_financiera"
                               value="{{ old('nombre_entidad_financiera', $entidad->nombre_entidad_financiera) }}"
                               required
                               autofocus>
                        @error('nombre_entidad_financiera')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="descripcion_entidad_financiera" class="form-label">
                            Descripción (Opcional)
                        </label>
                        <textarea class="form-control @error('descripcion_entidad_financiera') is-invalid @enderror"
                                  id="descripcion_entidad_financiera"
                                  name="descripcion_entidad_financiera"
                                  rows="4">{{ old('descripcion_entidad_financiera', $entidad->descripcion_entidad_financiera) }}</textarea>
                        @error('descripcion_entidad_financiera')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Información adicional --}}
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="text-muted small">TRANSACCIONES ASOCIADAS</h6>
                                    <h3 class="mb-0">{{ $entidad->transacciones->count() }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="text-muted small">FECHA DE CREACIÓN</h6>
                                    <h6 class="mb-0">{{ $entidad->fecha_creacion->format('d/m/Y H:i') }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($entidad->transacciones->count() > 0)
                        <div class="alert alert-warning">
                            <strong>⚠️ Atención:</strong> Esta entidad tiene {{ $entidad->transacciones->count() }}
                            transacción(es) asociada(s). Los cambios afectarán todas las transacciones que la usan.
                        </div>
                    @endif

                    <div class="d-flex justify-content-between">
                        <div>
                            @if($entidad->transacciones->count() === 0)
                                <button type="button"
                                        class="btn btn-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEliminar">
                                    🗑️ Eliminar Entidad
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
                            <a href="{{ route('entidades.index') }}"
                               class="btn btn-secondary">
                                Cancelar
                            </a>
                            <button type="submit"
                                    class="btn btn-warning">
                                Actualizar Entidad
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
                <p>¿Estás seguro de que deseas eliminar la entidad <strong>"{{ $entidad->nombre_entidad_financiera }}"</strong>?</p>
                <p class="text-danger mb-0">Esta acción no se puede deshacer.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="{{ route('entidades.destroy', $entidad->id_entidad_financiera) }}"
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
