<?php

namespace App\Observers;

use App\Models\Tipo;
use Illuminate\Support\Facades\Auth;

class TipoObserver
{
    /**
     * Handle the Tipo "creating" event.
     */
    public function creating(Tipo $tipo): void
    {
        // Asignar el usuario autenticado si no está asignado
        if (!$tipo->usuario_id && Auth::check()) {
            $tipo->usuario_id = Auth::user()->id_usuario;
        }
    }
}
