@extends('layouts.app')

@section('title', 'Nueva Categoría')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Nueva Categoría de Transacción</h1>
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
                <form action="{{ route('categorias.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="nombre_categoria_transaccion" class="form-label">
                            Nombre de la Categoría <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               class="form-control @error('nombre_categoria_transaccion') is-invalid @enderror"
                               id="nombre_categoria_transaccion"
                               name="nombre_categoria_transaccion"
                               value="{{ old('nombre_categoria_transaccion') }}"
                               placeholder="Ej: Alimentación, Transporte, Salud..."
                               required
                               autofocus>
                        @error('nombre_categoria_transaccion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            El nombre debe ser único y descriptivo
                        </small>
                    </div>

                    <div class="mb-4">
                        <label for="descripcion_categoria_transaccion" class="form-label">
                            Descripción (Opcional)
                        </label>
                        <textarea class="form-control @error('descripcion_categoria_transaccion') is-invalid @enderror"
                                  id="descripcion_categoria_transaccion"
                                  name="descripcion_categoria_transaccion"
                                  rows="4"
                                  placeholder="Describe para qué se utilizará esta categoría...">{{ old('descripcion_categoria_transaccion') }}</textarea>
                        @error('descripcion_categoria_transaccion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info">
                        <strong>💡 Tip:</strong> Las categorías te ayudan a organizar mejor tus transacciones.
                        Puedes crear categorías como: Hogar, Entretenimiento, Educación, Inversiones, etc.
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('categorias.index') }}"
                           class="btn btn-secondary">
                            Cancelar
                        </a>
                        <button
                            type="submit"
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
                        <h6 class="text-success">Ingresos:</h6>
                        <ul class="small">
                            <li>Salario</li>
                            <li>Freelance</li>
                            <li>Inversiones</li>
                            <li>Bonos</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-danger">Gastos:</h6>
                        <ul class="small">
                            <li>Alimentación</li>
                            <li>Transporte</li>
                            <li>Vivienda</li>
                            <li>Salud</li>
                            <li>Entretenimiento</li>
                            <li>Educación</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
