<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\empleado; 


class EmpleadosController extends Controller
{
    public function guardar(Request $request)
    {
        $request->validate([
            'codigo_empleado' => 'string|max:15|unique:empleados',
            'nombre' => 'string|max:50',
            'apellido' => 'string|max:50',
            'direccion' => 'string',
            'fecha_nacimiento' => 'date',
            'informacion_contacto' => 'string|max:100',
            'genero' => 'in:Masculino,Femenino,Otro',
            'id_puesto_trabajo' => 'exists:puestos_trabajo,id',
            
        ]);
       

        // Crear un nuevo empleado
        $empleado = new empleado();
        $empleado->codigo_empleado = $request->codigo_empleado;
        $empleado->nombre = $request->nombre;
        $empleado->apellido = $request->apellido;
        $empleado->direccion = $request->direccion;
        $empleado->fecha_nacimiento = $request->fecha_nacimiento;
        $empleado->informacion_contacto = $request->informacion_contacto;
        $empleado->genero = $request->genero;
        $empleado->id_puesto_trabajo = $request->id_puesto_trabajo;
       

        
        

        //aqui lo guardo en la base de datos
        $empleado->save();
       

        //mensaje de exito 
        return response()->json([
            'message' => 'Empleado creado correctamente',
            'empleado' => $empleado
        ], 201);
    }
}