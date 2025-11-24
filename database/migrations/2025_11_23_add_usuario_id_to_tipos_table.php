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
        Schema::table('tipos', function (Blueprint $table) {
            // Agregar columna usuario_id
            $table->unsignedBigInteger('usuario_id')->nullable()->after('id_tipo');

            // Agregar clave foránea
            $table->foreign('usuario_id')
                ->references('id_usuario')
                ->on('usuarios')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tipos', function (Blueprint $table) {
            // Eliminar clave foránea
            $table->dropForeign(['usuario_id']);
            // Eliminar columna
            $table->dropColumn('usuario_id');
        });
    }
};
