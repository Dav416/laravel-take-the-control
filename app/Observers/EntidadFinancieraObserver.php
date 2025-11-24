<?php

namespace App\Observers;

use App\Models\EntidadFinanciera;
use Illuminate\Support\Facades\Auth;

class EntidadFinancieraObserver
{
    /**
     * Handle the EntidadFinanciera "creating" event.
     */
    public function creating(EntidadFinanciera $entidadFinanciera): void
    {
        // Asignar el usuario autenticado si no está asignado
        if (!$entidadFinanciera->usuario_id && Auth::check()) {
            $entidadFinanciera->usuario_id = Auth::user()->id_usuario;
        }
    }
}
