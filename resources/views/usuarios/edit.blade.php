<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-warning">
            <h4 class="mb-0">Editar Usuario</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('usuarios.update', $usuario->id_usuario) }}" method="POST" novalidate>
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nombre_usuario" class="form-label">Nombre</label>
                    <input type="text" id="nombre_usuario" name="nombre_usuario"
                           class="form-control @error('nombre_usuario') is-invalid @enderror"
                           value="{{ old('nombre_usuario', $usuario->nombre_usuario) }}" required>
                    @error('nombre_usuario')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nombre_cuenta_usuario" class="form-label">Cuenta de usuario</label>
                    <input type="text" id="nombre_cuenta_usuario" name="nombre_cuenta_usuario"
                           class="form-control @error('nombre_cuenta_usuario') is-invalid @enderror"
                           value="{{ old('nombre_cuenta_usuario', $usuario->nombre_cuenta_usuario) }}" required>
                    @error('nombre_cuenta_usuario')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="correo_usuario" class="form-label">Correo electrónico</label>
                    <input type="email" id="correo_usuario" name="correo_usuario"
                           class="form-control @error('correo_usuario') is-invalid @enderror"
                           value="{{ old('correo_usuario', $usuario->correo_usuario) }}" required>
                    @error('correo_usuario')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="clave_usuario" class="form-label">Contraseña (dejar en blanco para no cambiar)</label>
                    <input type="password" id="clave_usuario" name="clave_usuario"
                           class="form-control @error('clave_usuario') is-invalid @enderror"
                           placeholder="••••••">
                    @error('clave_usuario')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning">✏️ Actualizar</button>
                    <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">↩ Volver</a>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
