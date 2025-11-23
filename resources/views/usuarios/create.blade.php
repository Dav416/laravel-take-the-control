@extends('layouts.app')

@section('title', 'Crear Usuario')

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Crear Usuario</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('usuarios.store') }}" method="POST" novalidate>
                @csrf

                <div class="mb-3">
                    <label for="nombre_usuario" class="form-label">Nombre</label>
                    <input type="text" id="nombre_usuario" name="nombre_usuario"
                           class="form-control @error('nombre_usuario') is-invalid @enderror"
                           value="{{ old('nombre_usuario') }}" required>
                    @error('nombre_usuario')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nombre_cuenta_usuario" class="form-label">Cuenta de usuario</label>
                    <input type="text" id="nombre_cuenta_usuario" name="nombre_cuenta_usuario"
                           class="form-control @error('nombre_cuenta_usuario') is-invalid @enderror"
                           value="{{ old('nombre_cuenta_usuario') }}" required>
                    @error('nombre_cuenta_usuario')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="correo_usuario" class="form-label">Correo electrónico</label>
                    <input type="email" id="correo_usuario" name="correo_usuario"
                           class="form-control @error('correo_usuario') is-invalid @enderror"
                           value="{{ old('correo_usuario') }}" required>
                    @error('correo_usuario')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="clave_usuario" class="form-label">Contraseña</label>
                    <input type="password" id="clave_usuario" name="clave_usuario"
                           class="form-control @error('clave_usuario') is-invalid @enderror"
                           required>
                    @error('clave_usuario')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar Usuario</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
