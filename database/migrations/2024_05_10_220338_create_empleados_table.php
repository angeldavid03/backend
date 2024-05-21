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
        Schema::create('empleados', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('codigo_empleado', 15)->unique('codigo_empleado_unique');
            $table->string('nombre', 50);
            $table->string('apellido', 50);
            $table->text('direccion');
            $table->date('fecha_nacimiento');
            $table->string('informacion_contacto', 100);
            $table->enum('genero', ['Masculino', 'Femenino', 'Otro']);
            $table->integer('id_puesto_trabajo')->index('id_puesto_trabajo');
            $table->binary('foto')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
