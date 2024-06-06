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
        Schema::create('registro_breaks', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('cd_empleado',15)->index('cd_empleado');
            $table->date('fecha');
            $table->time('salida_break1');
            $table->time('entrada_break1');
            $table->time('salida_almuerzo');
            $table->time('entrada_almuerzo');
            $table->time('salida_break2');
            $table->time('entrada_break2');
            $table->binary('foto')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_breaks');
    }
};
