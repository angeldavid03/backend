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

    protected $dates =[
        'created_at'
    ];

    public function adminlte_image()
    {
         // Detectar el tipo MIME de la imagen
         if ($this->foto) {
            // Detectar el tipo MIME de la imagen
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->buffer($this->foto);
    
            // Devolver la imagen en base64 con el tipo MIME correcto
            return 'data:' . $mimeType . ';base64,' . base64_encode($this->foto);
        } else {
            // Si no hay una imagen, devolver una imagen por defecto (puede ser un placeholder)
            return asset('path/to/default/image.png');
        }
    }

    public function adminlte_desc()
    {
        // Convertir a Carbon si es un string
        $fechaCreacion = $this->created_at instanceof Carbon ? $this->created_at : Carbon::parse($this->created_at);
        
        return $this->nombre . ' ' . $this->apellido .'            '.'Miembro desde: ' . $fechaCreacion->format('d/m/Y');
    }

    public function adminlte_profile_url()
    {
        // Ruta al perfil del administrador
        return route('admin.profile');
    }
}
