<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h1>Bienvenido 🎉</h1>
    <p>Hola, {{ session('usuario')->nombre_usuario ?? 'Usuario' }}</p>

    <!-- Botón logout -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-danger">Cerrar sesión</button>
    </form>
</div>

</body>
</html>
