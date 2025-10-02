<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Transacciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h1 class="mb-4">📊 Dashboard de Transacciones</h1>

    <div class="mb-3">
        <a href="{{ route('transacciones.create') }}" class="btn btn-primary">➕ Nueva Transacción</a>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">↩ Volver</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Descripción</th>
                <th>Monto</th>
                <th>Categoría</th>
                <th>Entidad Financiera</th>
                <th>Proyección</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @forelse($transacciones as $transaccion)
            <tr>
                <td>{{ $transaccion->id_transaccion }}</td>
                <td>{{ $transaccion->descripcion_transaccion }}</td>
                <td>${{ number_format($transaccion->monto, 2) }}</td>
                <td>{{ $transaccion->categoria }}</td>
                <td>{{ $transaccion->entidad_financiera }}</td>
                <td>{{ $transaccion->proyeccion_financiera }}</td>
                <td>{{ $transaccion->fecha_creacion->format('d/m/Y H:i') }}</td>
                <td>
                    <a href="{{ route('transacciones.edit', $transaccion->id_transaccion) }}" class="btn btn-sm btn-warning">✏️ Editar</a>
                    <form action="{{ route('transacciones.destroy', $transaccion->id_transaccion) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Seguro que quieres eliminar esta transacción?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">🗑 Eliminar</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="8" class="text-center">No hay transacciones registradas</td></tr>
        @endforelse
        </tbody>
    </table>

    <!-- Paginación -->
    <div class="mt-3">
        {{ $transacciones->links() }}
    </div>
</div>
</body>
</html>
