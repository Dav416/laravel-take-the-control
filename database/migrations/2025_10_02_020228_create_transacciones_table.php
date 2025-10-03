<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transacciones', function (Blueprint $table) {
            $table->bigIncrements('id_transaccion');
            $table->string('nombre_transaccion', 255);
            $table->text('descripcion_transaccion')->nullable();
            $table->decimal('valor_transaccion', 11, 0);

            // Columnas FK
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->unsignedBigInteger('entidad_financiera_id')->nullable();
            $table->unsignedBigInteger('proyeccion_financiera_id')->nullable();

            // Fechas personalizadas
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->timestamp('fecha_actualizacion')->useCurrent()->useCurrentOnUpdate();
            $table->timestamp('fecha_eliminacion')->nullable();
        });

        Schema::table('transacciones', function (Blueprint $table) {
            $table->foreign('categoria_id', 'fk_transacciones_categoria')
                  ->references('id_categoria_transaccion')
                  ->on('categorias_transacciones')
                  ->nullOnDelete();

            $table->foreign('entidad_financiera_id', 'fk_transacciones_entidad')
                  ->references('id_entidad_financiera')
                  ->on('entidades_financieras')
                  ->nullOnDelete();

            $table->foreign('proyeccion_financiera_id', 'fk_transacciones_proyeccion')
                  ->references('id_proyeccion_financiera')
                  ->on('proyecciones_financieras')
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transacciones');
    }
};
