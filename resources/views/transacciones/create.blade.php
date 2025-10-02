@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Crear Transacción</h2>

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

    <form action="{{ route('transacciones.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nombre_transaccion" class="form-label">Nombre de la Transacción</label>
            <input type="text" name="nombre_transaccion" id="nombre_transaccion"
                   class="form-control" value="{{ old('nombre_transaccion') }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion_transaccion" class="form-label">Descripción</label>
            <textarea name="descripcion_transaccion" id="descripcion_transaccion"
                      class="form-control">{{ old('descripcion_transaccion') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="valor_transaccion" class="form-label">Valor</label>
            <input type="number" name="valor_transaccion" id="valor_transaccion"
                   class="form-control" value="{{ old('valor_transaccion') }}" required>
        </div>

        <div class="mb-3">
            <label for="categoria" class="form-label">Categoría</label>
            <input type="text" name="categoria" id="categoria"
                   class="form-control" value="{{ old('categoria') }}" required>
        </div>

        <div class="mb-3">
            <label for="entidad_financiera" class="form-label">Entidad Financiera</label>
            <input type="text" name="entidad_financiera" id="entidad_financiera"
                   class="form-control" value="{{ old('entidad_financiera') }}" required>
        </div>

        <div class="mb-3">
            <label for="proyeccion_financiera" class="form-label">Proyección Financiera</label>
            <input type="text" name="proyeccion_financiera" id="proyeccion_financiera"
                   class="form-control" value="{{ old('proyeccion_financiera') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('transacciones.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
