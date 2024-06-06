<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Empleado extends Model
{
    use HasFactory;

    protected $table ='empleados';

    protected $primarykey = 'id';

    public $incrementing = true;

  

    protected $keytype = 'int';

    protected $fillable = [
        'codigo_empleado',
        'nombre',
        'apellido',
        'direccion',
        'fecha_nacimiento',
        'informacion_contacto',
        'genero',
        'id_puesto_trabajo',
        
       ];

       


    protected $dates = [
     'fecha_nacimiento',
     'created_at',
     'updated_at'
    ];

    public function puestotrabajo(){
        return $this->belongsTo(puestotrabajo::class,'id_puesto_trabajo');
    }
}