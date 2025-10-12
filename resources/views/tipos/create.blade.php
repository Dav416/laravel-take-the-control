@extends('layouts.app')

@section('title', 'Nuevo Tipo')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Nuevo Tipo Para Transacciones</h1>
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
            <div class="card-body">
                <form action="{{ route('tipos.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="nombre_tipo" class="form-label">
                            Nombre del Tipo <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               class="form-control @error('nombre_tipo') is-invalid @enderror"
                               id="nombre_tipo"
                               name="nombre_tipo"
                               value="{{ old('nombre_tipo') }}"
                               placeholder="Ej: Ingreso fijo, Egreso fijo, Ingreso variable..."
                               required
                               autofocus>
                        @error('nombre_tipo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            El nombre debe ser único y descriptivo
                        </small>
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
                                        {{ old('categoria_tipo_id') == $categoria->id_categoria_tipo ? 'selected' : '' }}>
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
                                  rows="4"
                                  placeholder="Describe para qué se utilizará este tipo...">{{ old('descripcion_tipo') }}</textarea>
                        @error('descripcion_tipo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info">
                        <strong>💡 Tip:</strong> Define tus tipos según la frecuencia o propósito del movimiento. Esto te permitirá analizar con mayor precisión tus hábitos financieros.
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('tipos.index') }}"
                           class="btn btn-secondary">
                            Cancelar
                        </a>
                        <button type="submit"
                                class="btn btn-success">
                            💾 Guardar Tipo
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Sugerencias de tipos --}}
        <div class="card mt-4 border-info">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0">💡 Sugerencias de Tipos de Transacción</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-success">Ingresos:</h6>
                        <ul class="small">
                            <li>Ingreso Fijo (salario, paga mensual, pensión)</li>
                            <li>Ingreso Extra (bonificaciones, ventas ocasionales)</li>
                            <li>Ingreso por Inversiones (intereses, dividendos)</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-danger">Gastos:</h6>
                        <ul class="small">
                            <li>Egreso Fijo (arriendo, servicios, suscripciones)</li>
                            <li>Egreso Ocasional (compras imprevistas o salidas)</li>
                            <li>Egreso por Inversión (compra de activos, ahorro a largo plazo)</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
