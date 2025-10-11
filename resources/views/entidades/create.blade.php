@extends('layouts.app')

@section('title', 'Nueva Entidad')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Nueva Entidad Financiera</h1>
            <a href="{{ route('entidades.index') }}" class="btn btn-secondary">
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
                <form action="{{ route('entidades.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="nombre_entidad_financiera" class="form-label">
                            Nombre de la Entidad <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               class="form-control @error('nombre_entidad_financiera') is-invalid @enderror"
                               id="nombre_entidad_financiera"
                               name="nombre_entidad_financiera"
                               value="{{ old('nombre_entidad_financiera') }}"
                               placeholder="Ej: Bancolombia, Banco Finandina, Nu Bank..."
                               required
                               autofocus>
                        @error('nombre_entidad_financiera')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            El nombre debe ser único y descriptivo
                        </small>
                    </div>

                    <div class="mb-4">
                        <label for="descripcion_entidad_financiera" class="form-label">
                            Descripción (Opcional)
                        </label>
                        <textarea class="form-control @error('descripcion_entidad_financiera') is-invalid @enderror"
                                  id="descripcion_entidad_financiera"
                                  name="descripcion_entidad_financiera"
                                  rows="4"
                                  placeholder="Describe para qué se utilizará esta entidad...">{{ old('descripcion_entidad_financiera') }}</textarea>
                        @error('descripcion_entidad_financiera')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info">
                        <strong>💡 Tip:</strong> Las entidades financieras te permiten identificar el origen o destino de tus fondos.
                        Puedes registrar entidades como: <strong>Bancos, Cooperativas, Billeteras Digitales</strong> o incluso <strong>Efectivo</strong> para llevar un control más preciso de tus transacciones.
                    </div>


                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('entidades.index') }}"
                           class="btn btn-secondary">
                            Cancelar
                        </a>
                        <button type="submit"
                                class="btn btn-success">
                            💾 Guardar Entidad
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Sugerencias de entidades financieras --}}
        <div class="card mt-4 border-info">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0">💡 Sugerencias de Entidades Financieras Comunes</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary">Bancos:</h6>
                        <ul class="small">
                            <li>Bancolombia</li>
                            <li>Davivienda</li>
                            <li>Banco de Bogotá</li>
                            <li>BBVA</li>
                            <li>Banco Popular</li>
                            <li>Banco de Occidente</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success">Cooperativas y otros:</h6>
                        <ul class="small">
                            <li>Coomeva</li>
                            <li>Colpatria</li>
                            <li>Nequi</li>
                            <li>Daviplata</li>
                            <li>Movii</li>
                            <li>Finandina</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
