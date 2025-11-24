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
        Schema::create('categorias_proyecciones', function (Blueprint $table) {
            $table->bigIncrements('id_categoria_proyeccion');
            $table->string('nombre_categoria_proyeccion', 255);
            $table->text('descripcion_categoria_proyeccion')->nullable();

            // Columnas FK
            $table->unsignedBigInteger('usuario_id')->nullable();

            // Fechas personalizadas
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->timestamp('fecha_actualizacion')->nullable()->useCurrentOnUpdate();
            $table->timestamp('fecha_eliminacion')->nullable();

            // Relaciones
            $table->foreign('usuario_id', 'fk_categorias_proyecciones_usuario')
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
        Schema::dropIfExists('categorias_proyecciones');
    }
};

