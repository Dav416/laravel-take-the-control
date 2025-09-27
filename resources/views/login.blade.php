<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4">Iniciar sesión</h2>

    <!-- Formulario de login -->
    <form method="POST" action="{{ route('login.post') }}">
        @csrf

        <div class="mb-3">
            <label for="correo_usuario" class="form-label">Correo electrónico</label>
            <input type="email" name="correo_usuario" id="correo_usuario" class="form-control" value="{{ old('correo_usuario') }}" required>
            @error('correo_usuario')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="clave_usuario" class="form-label">Contraseña</label>
            <input type="password" name="clave_usuario" id="clave_usuario" class="form-control" required>
            @error('clave_usuario')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        @error('error')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <button type="submit" class="btn btn-primary w-100">Ingresar</button>
    </form>
</div>

</body>
</html>
