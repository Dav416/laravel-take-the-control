<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saldos_disponibles', function (Blueprint $table) {
            $table->bigIncrements('id_saldo');
            $table->unsignedBigInteger('usuario_id');
            $table->integer('mes'); // 1-12
            $table->integer('anio'); // 2025, 2026, etc.
            $table->decimal('saldo_disponible', 15, 2)->default(0);
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->timestamp('fecha_actualizacion')->useCurrent()->useCurrentOnUpdate();

            // Foreign key
            $table->foreign('usuario_id', 'fk_saldos_usuario')
                  ->references('id_usuario')
                  ->on('usuarios')
                  ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saldos_disponibles');
    }
};
