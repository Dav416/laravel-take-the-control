<?php

namespace App\Observers;

use App\Models\CategoriaProyeccion;
use Illuminate\Support\Facades\Auth;

class CategoriaProyeccionObserver
{
    /**
     * Handle the CategoriaProyeccion "creating" event.
     */
    public function creating(CategoriaProyeccion $categoriaProyeccion): void
    {
        // Asignar el usuario autenticado si no está asignado
        if (!$categoriaProyeccion->usuario_id && Auth::check()) {
            $categoriaProyeccion->usuario_id = Auth::user()->id_usuario;
        }
    }
}
