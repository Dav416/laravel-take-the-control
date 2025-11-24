<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tipos', function (Blueprint $table) {
            $table->bigIncrements('id_tipo');
            $table->string('nombre_tipo', 55);
            $table->text('descripcion_tipo')->nullable();

            // Columnas FK
            $table->unsignedBigInteger('categoria_tipo_id')->nullable();
            $table->unsignedBigInteger('usuario_id')->nullable();

            $table->timestamp('fecha_creacion')->useCurrent();
            $table->timestamp('fecha_actualizacion')->useCurrent()->useCurrentOnUpdate();
            $table->timestamp('fecha_eliminacion')->nullable();

            // Relaciones
            $table->foreign('categoria_tipo_id', 'fk_tipos_categoria')
                ->references('id_categoria_tipo')
                ->on('categorias_tipos')
                ->nullOnDelete();

            $table->foreign('usuario_id', 'fk_tipos_usuario')
                ->references('id_usuario')
                ->on('usuarios')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tipos');
    }
};
