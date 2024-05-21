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
        Schema::create('registro_acceso', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('codigo_empleado', 15)->index('codigo_empleado');
            $table->timestamp('fecha_hora')->nullable()->useCurrent();
            $table->enum('tipo', ['inicio_sesion', 'cierre_sesion']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_acceso');
    }
};
