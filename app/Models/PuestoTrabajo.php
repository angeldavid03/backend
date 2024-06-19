<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PuestoTrabajo extends Model
{
    protected $table = 'puestos_trabajo';

    protected $fillable = [
        'nombre',
    ];

    // Relación con Empleados
    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'nombre_puesto_trabajo', 'nombre');
    }
}
