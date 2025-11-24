<?php

namespace App\Observers;

use App\Models\CategoriaTransaccion;
use Illuminate\Support\Facades\Auth;

class CategoriaTransaccionObserver
{
    /**
     * Handle the CategoriaTransaccion "creating" event.
     */
    public function creating(CategoriaTransaccion $categoriaTransaccion): void
    {
        // Asignar el usuario autenticado si no está asignado
        if (!$categoriaTransaccion->usuario_id && Auth::check()) {
            $categoriaTransaccion->usuario_id = Auth::user()->id_usuario;
        }
    }
}
