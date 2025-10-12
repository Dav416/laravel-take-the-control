@extends('layouts.app')

@section('title', 'Transacciones')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Transacciones</h1>
    <div>
        <a href="{{ route('transacciones.create') }}" class="btn btn-primary">
            + Nueva Transacción
        </a>
    </div>
</div>

{{-- Tarjeta de Saldo Disponible --}}
@if($saldoActual)
<div class="card mb-4 border-primary">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">💰 Saldo Disponible</h5>
        <small>{{ \Carbon\Carbon::create($saldoActual->anio, $saldoActual->mes)->locale('es')->isoFormat('MMMM YYYY') }}</small>
    </div>
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="mb-0 {{ $saldoActual->saldo_disponible > 0 ? 'text-success' : 'text-danger' }}">
                    ${{ number_format($saldoActual->saldo_disponible, 0, ',', '.') }}
                </h2>
                <small class="text-muted">
                    Última actualización: {{ $saldoActual->fecha_actualizacion->format('d/m/Y H:i') }}
                </small>
            </div>
            <div class="col-md-4 text-end">
                <button class="btn btn-outline-primary btn-sm" onclick="cambiarPeriodo()">
                    📅 Cambiar Periodo
                </button>
                <button class="btn btn-outline-secondary btn-sm" onclick="verHistorial()">
                    📊 Historial
                </button>
            </div>
        </div>
    </div>
</div>
@endif

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Valor</th>
                        <th>Tipo</th>
                        <th>Categoría</th>
                        <th>Entidad</th>
                        <th>Proyección</th>
                        <th>Fecha</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transacciones as $transaccion)
                        <tr>
                            <td>{{ $transaccion->id_transaccion }}</td>
                            <td>{{ $transaccion->nombre_transaccion }}</td>
                            <td>{{ Str::limit($transaccion->descripcion_transaccion, 40) }}</td>
                            <td class="fw-bold {{ $transaccion->tipo->categoria_tipo_id === 1 ? 'text-success' : 'text-danger' }}">
                                {{ $transaccion->tipo->categoria_tipo_id === 1 ? '+' : '-' }}${{ number_format($transaccion->valor_transaccion, 0, ',', '.') }}
                            </td>
                            <td>
                                <span class="badge {{ $transaccion->tipo->categoria_tipo_id === 1 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $transaccion->tipo->nombre_tipo ?? 'N/A' }}
                                </span>
                            </td>
                            <td>{{ $transaccion->categoria->nombre_categoria_transaccion ?? 'N/A' }}</td>
                            <td>{{ $transaccion->entidadFinanciera->nombre_entidad_financiera ?? 'N/A' }}</td>
                            <td>
                                @if($transaccion->proyeccionFinanciera)
                                    <span class="badge bg-info">
                                        {{ $transaccion->proyeccionFinanciera->nombre_proyeccion_financiera }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $transaccion->fecha_creacion->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <a href="{{ route('transacciones.edit', $transaccion->id_transaccion) }}"
                                   class="btn btn-sm btn-warning">
                                    Editar
                                </a>
                                <form action="{{ route('transacciones.destroy', $transaccion->id_transaccion) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('¿Estás seguro de eliminar esta transacción?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">
                                No hay transacciones registradas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mt-3">
    <div>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">↩ Volver</a>
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-secondary">Cerrar sesión</button>
        </form>
    </div>
    <div>
        {{ $transacciones->links('pagination::bootstrap-5') }}
    </div>
</div>

{{-- Modal para cambiar periodo --}}
<div class="modal fade" id="modalPeriodo" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cambiar Periodo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Mes</label>
                        <select id="mes" class="form-select">
                            @foreach(['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'] as $index => $mes)
                                <option value="{{ $index + 1 }}" {{ ($index + 1) == now()->month ? 'selected' : '' }}>
                                    {{ $mes }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Año</label>
                        <select id="anio" class="form-select">
                            @for($i = now()->year - 2; $i <= now()->year + 1; $i++)
                                <option value="{{ $i }}" {{ $i == now()->year ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="cargarSaldoPeriodo()">Consultar</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal para historial --}}
<div class="modal fade" id="modalHistorial" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">📊 Historial de Saldos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="historialContent">
                    <div class="text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
function cambiarPeriodo() {
    const modal = new bootstrap.Modal(document.getElementById('modalPeriodo'));
    modal.show();
}

function cargarSaldoPeriodo() {
    const mes = document.getElementById('mes').value;
    const anio = document.getElementById('anio').value;

    fetch(`/transacciones/saldo-disponible?mes=${mes}&anio=${anio}`)
        .then(response => response.json())
        .then(data => {
            alert(`Saldo de ${data.periodo}: $${new Intl.NumberFormat('es-CO').format(data.saldo_disponible)}`);
            bootstrap.Modal.getInstance(document.getElementById('modalPeriodo')).hide();
            location.reload(); // Recargar para mostrar el nuevo periodo
        })
        .catch(error => {
            alert('Error al consultar el saldo');
            console.error(error);
        });
}

function verHistorial() {
    const modal = new bootstrap.Modal(document.getElementById('modalHistorial'));
    modal.show();

    fetch('/transacciones/historial-saldos?limite=12')
        .then(response => response.json())
        .then(data => {
            let html = '<div class="table-responsive"><table class="table table-striped">';
            html += '<thead><tr><th>Periodo</th><th class="text-end">Saldo</th><th>Última Actualización</th></tr></thead><tbody>';

            data.forEach(item => {
                const color = item.saldo_disponible > 0 ? 'text-success' : 'text-danger';
                html += `<tr>
                    <td><strong>${item.periodo}</strong></td>
                    <td class="text-end ${color}"><strong>$${new Intl.NumberFormat('es-CO').format(item.saldo_disponible)}</strong></td>
                    <td><small class="text-muted">${item.fecha_actualizacion}</small></td>
                </tr>`;
            });

            html += '</tbody></table></div>';

            if (data.length === 0) {
                html = '<p class="text-center text-muted">No hay historial de saldos disponible</p>';
            }

            document.getElementById('historialContent').innerHTML = html;
        })
        .catch(error => {
            document.getElementById('historialContent').innerHTML =
                '<p class="text-center text-danger">Error al cargar el historial</p>';
            console.error(error);
        });
}
</script>
@endsection
