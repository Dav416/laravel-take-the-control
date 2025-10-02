@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Editar Transacción</h2>

    {{-- Mostrar errores de validación --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('transacciones.update', $transaccion->id_transaccion) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nombre_transaccion" class="form-label">Nombre de la Transacción</label>
            <input type="text" name="nombre_transaccion" id="nombre_transaccion"
                   class="form-control" value="{{ old('nombre_transaccion', $transaccion->nombre_transaccion) }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion_transaccion" class="form-label">Descripción</label>
            <textarea name="descripcion_transaccion" id="descripcion_transaccion"
                      class="form-control">{{ old('descripcion_transaccion', $transaccion->descripcion_transaccion) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="valor_transaccion" class="form-label">Valor</label>
            <input type="number" name="valor_transaccion" id="valor_transaccion"
                   class="form-control" value="{{ old('valor_transaccion', $transaccion->valor_transaccion) }}" required>
        </div>

        <div class="mb-3">
            <label for="categorias" class="form-label">Categoría</label>
            <input type="text" name="categorias" id="categorias"
                   class="form-control" value="{{ old('categorias', $transaccion->categorias) }}" required>
        </div>

        <div class="mb-3">
            <label for="entidades_financieras" class="form-label">Entidad Financiera</label>
            <input type="text" name="entidades_financieras" id="entidades_financieras"
                   class="form-control" value="{{ old('entidades_financieras', $transaccion->entidades_financieras) }}" required>
        </div>

        <div class="mb-3">
            <label for="proyecciones_financieras" class="form-label">Proyección Financiera</label>
            <input type="text" name="proyecciones_financieras" id="proyecciones_financieras"
                   class="form-control" value="{{ old('proyecciones_financieras', $transaccion->proyecciones_financieras) }}" required>
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('transacciones.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
