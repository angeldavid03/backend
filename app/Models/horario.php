<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class horario extends Model
{
    protected $table = 'horarios';

    protected $fillable = [
        'nombre_emp',
        'hora_entrada',
        'hora_salida',
        'foto',
    ];

    // Relación con Empleado
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'nombre_emp', 'nombre');
    }
}
