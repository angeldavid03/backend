<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class admin extends Authenticatable
{
    use HasFactory;

    protected $table = 'admin';

    
    protected $primaryKey = 'id';

    // No utilizar timestamps automáticos
    public $timestamps = false;

    // Atributos que se pueden asignar de forma masiva
    protected $fillable = [
        'username',
        'password',
        'nombre',
        'apellido',
        'email',
        'foto'
    ];

    // Ocultar atributos en las respuestas JSON
    protected $hidden = [
        'password'
    ];
}
