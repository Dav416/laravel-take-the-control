<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Transaccion;
use App\Models\Tipo;
use App\Models\CategoriaTransaccion;
use App\Models\EntidadFinanciera;
use App\Models\CategoriaProyeccion;
use App\Observers\TransaccionObserver;
use App\Observers\TipoObserver;
use App\Observers\CategoriaTransaccionObserver;
use App\Observers\EntidadFinancieraObserver;
use App\Observers\CategoriaProyeccionObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Registrar los observers
        Transaccion::observe(TransaccionObserver::class);
        Tipo::observe(TipoObserver::class);
        CategoriaTransaccion::observe(CategoriaTransaccionObserver::class);
        EntidadFinanciera::observe(EntidadFinancieraObserver::class);
        CategoriaProyeccion::observe(CategoriaProyeccionObserver::class);
    }
}
