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
        Schema::create('proyecciones_financieras', function (Blueprint $table) {
            $table->bigIncrements('id_proyeccion_financiera');
            $table->string('nombre_proyeccion_financiera', 255);
            $table->text('descripcion_proyeccion_financiera')->nullable();
            $table->decimal('meta_proyeccion_financiera', 15, 2)->default(0);

            // Solo columnas, sin FK
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->unsignedBigInteger('usuario_id');

            $table->timestamp('fecha_creacion')->useCurrent();
            $table->timestamp('fecha_actualizacion')->nullable()->useCurrentOnUpdate();
            $table->timestamp('fecha_eliminacion')->nullable();
        });

        // FK separadas con nombres cortos
        Schema::table('proyecciones_financieras', function (Blueprint $table) {
            $table->foreign('categoria_id', 'fk_proyecciones_categoria')
                ->references('id_categoria_proyeccion')
                ->on('categorias_proyecciones')
                ->nullOnDelete();

            $table->foreign('usuario_id', 'fk_proyecciones_usuario')
                ->references('id_usuario')
                ->on('usuarios')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proyecciones_financieras'); // ← corregir
    }
};
