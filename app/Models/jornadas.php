<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jornadas extends Model
{
    protected $table = 'jornadas';

    protected $fillable = [
        'entrada',
        'salida',
    ];

    // Relación con Empleados
    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'id_jornadas', 'id');
    }
}
