<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Empleado extends Model
{
    protected $table = 'empleados';
    public $timestamps = false;
   

    protected $fillable = [
        'codigo_empleado',
        'nombre',
        'apellido',
        'direccion',
        'fecha_nacimiento',
        'informacion_contacto',
        'genero',
        'id_puesto_trabajo',
        'id_jornadas',
        'foto',
        'created_at',
    ];

    



    // Relación con Puesto de Trabajo
    public function puestoTrabajo()
    {
        return $this->belongsTo(PuestoTrabajo::class, 'id_puesto_trabajo', 'id');
    }

    // Relación con Jornadas
    public function jornadas()
    {
        return $this->belongsTo(Jornadas::class, 'id_jornadas', 'id');
    }
}
