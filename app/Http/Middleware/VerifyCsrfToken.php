<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Rutas que se excluyen de la verificación CSRF.
     * Aquí excluimos las rutas API bajo /api/*
     */
    protected $except = [
        'api/*',
    ];
}
