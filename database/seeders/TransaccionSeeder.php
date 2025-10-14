<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaccion;
use App\Models\CategoriaTransaccion;
use App\Models\EntidadFinanciera;
use App\Models\ProyeccionFinanciera;
use App\Models\Tipo;
use App\Models\Usuario;

class TransaccionSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener tipos
        $tipoIngreso = Tipo::where('nombre_tipo', 'Ingreso')->first();
        $tipoEgreso = Tipo::where('nombre_tipo', 'Egreso')->first();

        // Obtener categorías
        $catSalario = CategoriaTransaccion::where('nombre_categoria_transaccion', 'Salario')->first();
        $catAlimentacion = CategoriaTransaccion::where('nombre_categoria_transaccion', 'Alimentación')->first();
        $catTransporte = CategoriaTransaccion::where('nombre_categoria_transaccion', 'Transporte')->first();
        $catInversiones = CategoriaTransaccion::where('nombre_categoria_transaccion', 'Inversiones')->first();
        $catVivienda = CategoriaTransaccion::where('nombre_categoria_transaccion', 'Vivienda')->first();
        $catOtros = CategoriaTransaccion::where('nombre_categoria_transaccion', 'Otros')->first();

        // Obtener entidades
        $bancolombia = EntidadFinanciera::where('nombre_entidad_financiera', 'Bancolombia')->first();
        $nequi = EntidadFinanciera::where('nombre_entidad_financiera', 'Nequi')->first();
        $efectivo = EntidadFinanciera::where('nombre_entidad_financiera', 'Efectivo')->first();

        // Obtener proyecciones específicas
        $proyVacaciones = ProyeccionFinanciera::where('nombre_proyeccion_financiera', 'Ahorro para vacaciones 2025')->first();
        $proyEmergencia = ProyeccionFinanciera::where('nombre_proyeccion_financiera', 'Fondo de emergencia')->first();
        $proyCDT = ProyeccionFinanciera::where('nombre_proyeccion_financiera', 'Inversión en CDT')->first();

        // Obtener usuario
        $usuario = Usuario::where('correo_usuario', 'test@example.com')->first();

        $transacciones = [
            [
                'nombre_transaccion' => 'Salario Octubre',
                'descripcion_transaccion' => 'Pago de nómina mensual',
                'valor_transaccion' => 3500000,
                'tipo_id' => $tipoIngreso->id_tipo,
                'categoria_id' => $catSalario->id_categoria_transaccion,
                'entidad_financiera_id' => $bancolombia->id_entidad_financiera,
                'proyeccion_financiera_id' => null, // Ingreso regular, no va a proyección
                'usuario_id' => $usuario->id_usuario,
            ],
            [
                'nombre_transaccion' => 'Supermercado',
                'descripcion_transaccion' => 'Compra quincenal en Éxito',
                'valor_transaccion' => 300000,
                'tipo_id' => $tipoEgreso->id_tipo,
                'categoria_id' => $catAlimentacion->id_categoria_transaccion,
                'entidad_financiera_id' => $nequi->id_entidad_financiera,
                'proyeccion_financiera_id' => null, // Gasto regular
                'usuario_id' => $usuario->id_usuario,
            ],
            [
                'nombre_transaccion' => 'Gasolina',
                'descripcion_transaccion' => 'Tanque lleno para 10 días',
                'valor_transaccion' => 50000,
                'tipo_id' => $tipoEgreso->id_tipo,
                'categoria_id' => $catTransporte->id_categoria_transaccion,
                'entidad_financiera_id' => $efectivo->id_entidad_financiera,
                'proyeccion_financiera_id' => null, // Gasto regular
                'usuario_id' => $usuario->id_usuario,
            ],
            [
                'nombre_transaccion' => 'Ahorro vacaciones',
                'descripcion_transaccion' => 'Aporte mensual a meta de vacaciones',
                'valor_transaccion' => 500000,
                'tipo_id' => $tipoIngreso->id_tipo,
                'categoria_id' => $catOtros->id_categoria_transaccion,
                'entidad_financiera_id' => $bancolombia->id_entidad_financiera,
                'proyeccion_financiera_id' => $proyVacaciones->id_proyeccion_financiera ?? null,
                'usuario_id' => $usuario->id_usuario,
            ],
            [
                'nombre_transaccion' => 'Transferencia fondo emergencia',
                'descripcion_transaccion' => 'Ahorro mensual para imprevistos',
                'valor_transaccion' => 300000,
                'tipo_id' => $tipoIngreso->id_tipo,
                'categoria_id' => $catVivienda->id_categoria_transaccion,
                'entidad_financiera_id' => $bancolombia->id_entidad_financiera,
                'proyeccion_financiera_id' => $proyEmergencia->id_proyeccion_financiera ?? null,
                'usuario_id' => $usuario->id_usuario,
            ],
            [
                'nombre_transaccion' => 'Aporte CDT',
                'descripcion_transaccion' => 'Inversión en certificado de depósito',
                'valor_transaccion' => 400000,
                'tipo_id' => $tipoIngreso->id_tipo,
                'categoria_id' => $catInversiones->id_categoria_transaccion,
                'entidad_financiera_id' => $nequi->id_entidad_financiera,
                'proyeccion_financiera_id' => $proyCDT->id_proyeccion_financiera ?? null,
                'usuario_id' => $usuario->id_usuario,
            ],
        ];

        foreach ($transacciones as $transaccion) {
            Transaccion::create($transaccion);
        }
    }
}
