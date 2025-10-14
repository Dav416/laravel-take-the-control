@extends('layouts.app')

@section('title', 'Nueva Categoría de Proyección')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Nueva Categoría de Proyección</h1>
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
                <form action="{{ route('categorias-proyecciones.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="nombre_categoria_proyeccion" class="form-label">
                            Nombre de la Categoría <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               class="form-control @error('nombre_categoria_proyeccion') is-invalid @enderror"
                               id="nombre_categoria_proyeccion"
                               name="nombre_categoria_proyeccion"
                               value="{{ old('nombre_categoria_proyeccion') }}"
                               placeholder="Ej: Ahorro, Inversión, Vacaciones..."
                               required
                               autofocus>
                        @error('nombre_categoria_proyeccion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            El nombre debe ser único y descriptivo
                        </small>
                    </div>

                    <div class="mb-4">
                        <label for="descripcion_categoria_proyeccion" class="form-label">
                            Descripción (Opcional)
                        </label>
                        <textarea class="form-control @error('descripcion_categoria_proyeccion') is-invalid @enderror"
                                  id="descripcion_categoria_proyeccion"
                                  name="descripcion_categoria_proyeccion"
                                  rows="4"
                                  placeholder="Describe el propósito de esta categoría...">{{ old('descripcion_categoria_proyeccion') }}</textarea>
                        @error('descripcion_categoria_proyeccion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info">
                        <strong>💡 Tip:</strong> Las categorías te ayudan a organizar tus proyecciones financieras.
                        Crea categorías según tus objetivos: Ahorro, Inversión, Deuda, Educación, etc.
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('categorias-proyecciones.index') }}"
                           class="btn btn-secondary">
                            Cancelar
                        </a>
                        <button type="submit"
                                class="btn btn-info text-white">
                            Guardar Categoría
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Sugerencias de categorías --}}
        <div class="card mt-4 border-info">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0">💡 Sugerencias de Categorías Comunes</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary">Para Ahorros:</h6>
                        <ul class="small">
                            <li>Fondo de emergencia</li>
                            <li>Ahorro para vivienda</li>
                            <li>Vacaciones</li>
                            <li>Vehículo</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success">Para Inversiones:</h6>
                        <ul class="small">
                            <li>Inversión en CDT</li>
                            <li>Portafolio de acciones</li>
                            <li>Criptomonedas</li>
                            <li>Negocio propio</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-warning">Para Deudas:</h6>
                        <ul class="small">
                            <li>Pago de tarjeta de crédito</li>
                            <li>Préstamo bancario</li>
                            <li>Deuda familiar</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-info">Otros:</h6>
                        <ul class="small">
                            <li>Educación</li>
                            <li>Salud</li>
                            <li>Hogar</li>
                            <li>Tecnología</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
