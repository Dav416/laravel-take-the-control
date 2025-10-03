@extends('layouts.app')

@section('title', 'Nueva Transacción')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Nueva Transacción</h1>
            <a href="{{ route('transacciones.index') }}" class="btn btn-secondary">
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

        <div class="card">
            <div class="card-body">
                <form action="{{ route('transacciones.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="nombre_transaccion" class="form-label">
                            Nombre de la Transacción <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               class="form-control @error('nombre_transaccion') is-invalid @enderror"
                               id="nombre_transaccion"
                               name="nombre_transaccion"
                               value="{{ old('nombre_transaccion') }}"
                               required>
                        @error('nombre_transaccion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="descripcion_transaccion" class="form-label">Descripción</label>
                        <textarea class="form-control @error('descripcion_transaccion') is-invalid @enderror"
                                  id="descripcion_transaccion"
                                  name="descripcion_transaccion"
                                  rows="3">{{ old('descripcion_transaccion') }}</textarea>
                        @error('descripcion_transaccion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="valor_transaccion" class="form-label">
                                Valor (COP) <span class="text-danger">*</span>
                            </label>
                            <input type="number"
                                   class="form-control @error('valor_transaccion') is-invalid @enderror"
                                   id="valor_transaccion"
                                   name="valor_transaccion"
                                   value="{{ old('valor_transaccion') }}"
                                   step="0.01"
                                   required>
                            @error('valor_transaccion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="categoria_id" class="form-label">
                                Categoría <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('categoria_id') is-invalid @enderror"
                                    id="categoria_id"
                                    name="categoria_id"
                                    required>
                                <option value="">Seleccione una categoría</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id_categoria_transaccion }}"
                                            {{ old('categoria_id') == $categoria->id_categoria_transaccion ? 'selected' : '' }}>
                                        {{ $categoria->nombre_categoria_transaccion }}
                                    </option>
                                @endforeach
                            </select>
                            @error('categoria_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="entidad_financiera_id" class="form-label">
                                Entidad Financiera <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('entidad_financiera_id') is-invalid @enderror"
                                    id="entidad_financiera_id"
                                    name="entidad_financiera_id"
                                    required>
                                <option value="">Seleccione una entidad</option>
                                @foreach($entidades as $entidad)
                                    <option value="{{ $entidad->id_entidad_financiera }}"
                                            {{ old('entidad_financiera_id') == $entidad->id_entidad_financiera ? 'selected' : '' }}>
                                        {{ $entidad->nombre_entidad_financiera }}
                                    </option>
                                @endforeach
                            </select>
                            @error('entidad_financiera_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="proyeccion_financiera_id" class="form-label">
                                Proyección Financiera (Opcional)
                            </label>
                            <select class="form-select @error('proyeccion_financiera_id') is-invalid @enderror"
                                    id="proyeccion_financiera_id"
                                    name="proyeccion_financiera_id">
                                <option value="">Sin proyección</option>
                                @foreach($proyecciones as $proyeccion)
                                    <option value="{{ $proyeccion->id_proyeccion_financiera }}"
                                            {{ old('proyeccion_financiera_id') == $proyeccion->id_proyeccion_financiera ? 'selected' : '' }}>
                                        {{ $proyeccion->nombre_proyeccion_financiera }}
                                    </option>
                                @endforeach
                            </select>
                            @error('proyeccion_financiera_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('transacciones.index') }}" class="btn btn-secondary">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Guardar Transacción
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
