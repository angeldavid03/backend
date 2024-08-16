<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PuestoTrabajo extends Model
{
    protected $table = 'puestos_trabajo';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
    ];

    // Relación con Empleados
    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'id_puesto_trabajo', 'id');
    }
}
