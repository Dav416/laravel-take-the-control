<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->bigIncrements('id_usuario'); // PK autoincrement
            $table->string('nombre_usuario', 255);
            $table->string('nombre_cuenta_usuario', 255)->unique();
            $table->string('clave_usuario', 255);
            $table->string('correo_usuario', 255)->unique();
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->timestamp('fecha_actualizacion')->useCurrent()->useCurrentOnUpdate();
            $table->timestamp('fecha_eliminacion')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
