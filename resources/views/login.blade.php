<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container vh-100 d-flex justify-content-center align-items-center">
    <div class="col-md-4">
        <div class="card shadow-lg">
            <div class="card-header text-center bg-primary text-white">
                <h4>Iniciar sesión</h4>
            </div>
            <div class="card-body">
                <!-- Formulario de login -->
                <form method="POST" action="{{ route('login.post') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="correo_usuario" class="form-label">Correo electrónico</label>
                        <input type="email" name="correo_usuario" id="correo_usuario"
                               class="form-control @error('correo_usuario') is-invalid @enderror"
                               value="{{ old('correo_usuario') }}" required>
                        @error('correo_usuario')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="clave_usuario" class="form-label">Contraseña</label>
                        <input type="password" name="clave_usuario" id="clave_usuario"
                               class="form-control @error('clave_usuario') is-invalid @enderror"
                               required>
                        @error('clave_usuario')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    @error('error')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <button type="submit" class="btn btn-primary w-100">Entrar</button>
                </form>
            </div>
            <div class="card-footer text-center">
                <small>© {{ date('Y') }} Take The Control</small>
            </div>
        </div>
    </div>
</div>

</body>
</html>
