<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Transacciones', function (Blueprint $table) {
            $table->bigIncrements('id_transaccion'); // PK autoincrement
            $table->string('nombre_transaccion', 255);
            $table->text('descripcion_transaccion')->nullable();
            $table->decimal('valor_transaccion', 11, 0);

            // Campos directos en la entidad
            $table->string('categoria', 255)->nullable();
            $table->string('entidad_financiera', 255)->nullable();
            $table->string('proyeccion_financiera', 255)->nullable();

            // Fechas personalizadas
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->timestamp('fecha_actualizacion')->useCurrent()->useCurrentOnUpdate();
            $table->timestamp('fecha_eliminacion')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Transacciones');
    }
};
