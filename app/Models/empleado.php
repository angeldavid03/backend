<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Empleado extends Model
{
    use HasFactory;

    protected $table = 'empleados'; // Nombre de la tabla de base de datos

    protected $primaryKey = 'codigo_empleado'; // Clave primaria de la tabla

    public $incrementing = false; // Indica que la clave primaria no es autoincremental

    protected $keyType = 'string'; // Tipo de dato de la clave primaria

    protected $fillable = [
        'codigo_empleado',
        'nombre',
        'apellido',
        'direccion',
        'fecha_nacimiento',
        'informacion_contacto',
        'genero',
        'id_puesto_trabajo',
        'foto',
        
    ];

    protected $dates = [
        'fecha_nacimiento',
        'created_at',
        'updated_at'
    ];

    // Relación con el modelo PuestoTrabajo
    public function puestoTrabajo()
    {
        return $this->belongsTo(PuestoTrabajo::class, 'id_puesto_trabajo', 'id');
    }
}