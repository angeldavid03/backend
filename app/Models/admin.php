<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

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

    public function adminlte_image()
    {
        return 'data:image/jpeg;base64,' . base64_encode($this->foto);
    }

    public function adminlte_desc()
    {
        // Formatear la fecha de creación
        $fechaRegistro = Carbon::parse($this->created_at)->format('d/m/Y');
        
        // Devolver el nombre completo y la fecha de registro
        return "{$this->nombre} {$this->apellido} -  Miembro desde: {$fechaRegistro}";
    }

    public function adminlte_profile_url()
    {
        // Ruta al perfil del administrador
        return route('admin.profile');
    }
}
