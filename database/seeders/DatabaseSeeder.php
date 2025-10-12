<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // IMPORTANTE: Respetar el orden debido a las FK
        $this->call([
            // 1. Tablas sin dependencias
            CategoriaProyeccionSeeder::class,
            CategoriaTransaccionSeeder::class,
            CategoriaTipoSeeder::class,
            EntidadFinancieraSeeder::class,
            UsuariosSeeder::class,
            TipoSeeder::class,

            // 2. Tablas con dependencias
            ProyeccionFinancieraSeeder::class, // Depende de Usuario y CategoriaProyeccion

            // 3. Transacciones (depende de todo)
            TransaccionSeeder::class,
        ]);

        $this->command->info('✅ Seeders ejecutados correctamente');
    }
}
