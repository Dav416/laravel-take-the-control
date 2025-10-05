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
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->timestamp('fecha_actualizacion')->useCurrent()->useCurrentOnUpdate();
            $table->timestamp('fecha_eliminacion')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tipos');
    }
};
