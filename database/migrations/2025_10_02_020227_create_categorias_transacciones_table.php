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
        Schema::create('categorias_transacciones', function (Blueprint $table) {
            $table->bigIncrements('id_categoria_transaccion');
            $table->string('nombre_categoria_transaccion', 255);
            $table->text('descripcion_categoria_transaccion')->nullable();

            // Fechas personalizadas
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->timestamp('fecha_actualizacion')->nullable()->useCurrentOnUpdate();
            $table->timestamp('fecha_eliminacion')->nullable();

            // SoftDeletes personalizado (sin created_at y updated_at estándar)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias_transacciones');
    }
};
