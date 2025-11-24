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
        Schema::create('entidades_financieras', function (Blueprint $table) {
            $table->bigIncrements('id_entidad_financiera');
            $table->string('nombre_entidad_financiera', 255);
            $table->text('descripcion_entidad_financiera')->nullable();

            // Columnas FK
            $table->unsignedBigInteger('usuario_id')->nullable();

            // Fechas personalizadas
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->timestamp('fecha_actualizacion')->nullable()->useCurrentOnUpdate();
            $table->timestamp('fecha_eliminacion')->nullable();

            // Relaciones
            $table->foreign('usuario_id', 'fk_entidades_financieras_usuario')
                ->references('id_usuario')
                ->on('usuarios')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entidades_financieras');
    }
};
