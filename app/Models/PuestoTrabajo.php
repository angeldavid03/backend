<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class puestotrabajo extends Model
{
    use HasFactory;

    protected $table = 'puestos_trabajo';

    protected $fillable = [
        'id',
        'nombre'
        
    ];
    public $timestamps = false;

    public function empleados()
    {
        return $this->hasMany(empleado::class, 'id_puesto_trabajo', 'id');
    }
}
