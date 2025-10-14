@extends('layouts.app')

@section('title', 'Nueva Proyección Financiera')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Nueva Proyección Financiera</h1>
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
            <div class="card-body">
                <form action="{{ route('proyecciones.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="nombre_proyeccion_financiera" class="form-label">
                            Nombre de la Proyección <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               class="form-control @error('nombre_proyeccion_financiera') is-invalid @enderror"
                               id="nombre_proyeccion_financiera"
                               name="nombre_proyeccion_financiera"
                               value="{{ old('nombre_proyeccion_financiera') }}"
                               placeholder="Ej: Ahorro para vacaciones 2025"
                               required
                               autofocus>
                        @error('nombre_proyeccion_financiera')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            Dale un nombre descriptivo a tu meta financiera
                        </small>
                    </div>

                    <div class="mb-4">
                        <label for="descripcion_proyeccion_financiera" class="form-label">
                            Descripción (Opcional)
                        </label>
                        <textarea class="form-control @error('descripcion_proyeccion_financiera') is-invalid @enderror"
                                  id="descripcion_proyeccion_financiera"
                                  name="descripcion_proyeccion_financiera"
                                  rows="3"
                                  placeholder="Describe tu meta y cómo planeas alcanzarla...">{{ old('descripcion_proyeccion_financiera') }}</textarea>
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
                                       value="{{ old('meta_proyeccion_financiera') }}"
                                       step="0.01"
                                       min="0"
                                       placeholder="0.00"
                                       required>
                                @error('meta_proyeccion_financiera')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="form-text text-muted">
                                ¿Cuánto dinero quieres alcanzar?
                            </small>
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
                                            {{ old('categoria_id') == $categoria->id_categoria_proyeccion ? 'selected' : '' }}>
                                        {{ $categoria->nombre_categoria_proyeccion }}
                                    </option>
                                @endforeach
                            </select>
                            @error('categoria_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted btn btn-info ">
                                <a class="text-white text-decoration-none" href="{{ route('categorias-proyecciones.create') }}" target="_blank">
                                    + Crear nueva categoría
                                </a>
                            </small>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <h6 class="alert-heading">💡 ¿Cómo funcionan las proyecciones?</h6>
                        <ul class="mb-0 small">
                            <li>Define una <strong>meta</strong> que deseas alcanzar</li>
                            <li>Crea transacciones de <strong>tipo Ingreso</strong> y asígnalas a esta proyección</li>
                            <li>El sistema calculará automáticamente tu progreso</li>
                            <li>Cuando uses dinero de la proyección, crea transacciones de <strong>tipo Egreso</strong> asociadas</li>
                        </ul>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('proyecciones.index') }}"
                           class="btn btn-secondary">
                            Cancelar
                        </a>
                        <button type="submit"
                                class="btn btn-info text-white">
                            Guardar Proyección
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Ejemplos de proyecciones --}}
        <div class="card mt-4 border-info">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0">🎯 Ejemplos de Proyecciones</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-success">Para Ahorros:</h6>
                        <ul class="small">
                            <li>Fondo de emergencia ($5,000,000)</li>
                            <li>Vacaciones familiares ($3,000,000)</li>
                            <li>Enganche de carro ($10,000,000)</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-warning">Para Inversiones:</h6>
                        <ul class="small">
                            <li>Inversión en CDT ($15,000,000)</li>
                            <li>Portafolio de acciones ($20,000,000)</li>
                            <li>Proyecto personal ($8,000,000)</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
