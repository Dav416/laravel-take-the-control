<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EntidadFinanciera;

class EntidadFinancieraSeeder extends Seeder
{
    public function run(): void
    {
        $entidades = [
            // Bancos colombianos principales
            [
                'nombre_entidad_financiera' => 'Bancolombia',
                'descripcion_entidad_financiera' => 'Banco comercial y de inversión',
            ],
            [
                'nombre_entidad_financiera' => 'Banco de Bogotá',
                'descripcion_entidad_financiera' => 'Entidad bancaria tradicional',
            ],
            [
                'nombre_entidad_financiera' => 'Davivienda',
                'descripcion_entidad_financiera' => 'Banco con servicios integrales',
            ],
            [
                'nombre_entidad_financiera' => 'BBVA Colombia',
                'descripcion_entidad_financiera' => 'Banco internacional con presencia local',
            ],
            [
                'nombre_entidad_financiera' => 'Banco Agrario',
                'descripcion_entidad_financiera' => 'Banco público de servicios financieros',
            ],
            [
                'nombre_entidad_financiera' => 'Nequi',
                'descripcion_entidad_financiera' => 'Billetera digital y soluciones fintech',
            ],
            [
                'nombre_entidad_financiera' => 'Daviplata',
                'descripcion_entidad_financiera' => 'Cuenta de ahorros digital',
            ],

            // Otras opciones
            [
                'nombre_entidad_financiera' => 'Efectivo',
                'descripcion_entidad_financiera' => 'Dinero en efectivo físico',
            ],
            [
                'nombre_entidad_financiera' => 'Tarjeta de Crédito',
                'descripcion_entidad_financiera' => 'Pagos con tarjeta de crédito',
            ],
            [
                'nombre_entidad_financiera' => 'Otro',
                'descripcion_entidad_financiera' => 'Otras entidades financieras',
            ],
        ];

        foreach ($entidades as $entidad) {
            EntidadFinanciera::create($entidad);
        }
    }
}
