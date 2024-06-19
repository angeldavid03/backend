<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'empleados';

    protected $fillable = [
        'codigo_empleado',
        'nombre',
        'apellido',
        'direccion',
        'fecha_nacimiento',
        'informacion_contacto',
        'genero',
        'nombre_puesto_trabajo',
        'id_jornadas',
        'foto',
    ];

    // Relación con Puesto de Trabajo
    public function puestoTrabajo()
    {
        return $this->belongsTo(PuestoTrabajo::class, 'nombre_puesto_trabajo', 'nombre');
    }

    // Relación con Jornadas
    public function jornadas()
    {
        return $this->belongsTo(Jornadas::class, 'id_jornadas', 'id');
    }
}
