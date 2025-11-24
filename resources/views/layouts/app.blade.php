<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mi App')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">Take The Control</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="{{ route('usuarios.index') }}" class="nav-link">Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('transacciones.index') }}" class="nav-link">Transacciones</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('categorias.index') }}" class="nav-link">Categorías</a>
                    </li>
                    <li class="nav-item d-flex align-items-center">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm fw-bold ms-1">Cerrar Sesión</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Contenido dinámico --}}
    <div class="container">
        @yield('content')
    </div>

    @yield('scripts')
</body>
</html>
