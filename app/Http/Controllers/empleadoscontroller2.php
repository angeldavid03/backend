<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;

class empleadoscontroller2 extends Controller
{
    public function index()
    {
        return Empleado::all();
    }

    public function show($id)
    {
        $empleado = Empleado::find($id);
        if ($empleado) {
            return response()->json($empleado);
        } else {
            return response()->json(['error' => 'Empleado no encontrado'], 404);
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo_empleado' => 'required|string|max:15|unique:empleados',
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'direccion' => 'required|string',
            'fecha_nacimiento' => 'required|date',
            'informacion_contacto' => 'required|string|max:100',
            'genero' => 'required|in:Masculino,Femenino,Otro',
            'id_puesto_trabajo' => 'required|integer',
            'id_jornadas' => 'required|integer',
            'foto' => 'nullable|binary',
        ]);

        $empleado = Empleado::create($validated);

        return response()->json($empleado, 201);
    }

    public function update(Request $request, $id)
    {
        $empleado = Empleado::find($id);
        if (!$empleado) {
            return response()->json(['error' => 'Empleado no encontrado'], 404);
        }

        $validated = $request->validate([
            'codigo_empleado' => 'required|string|max:15|unique:empleados,codigo_empleado,' . $id,
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'direccion' => 'required|string',
            'fecha_nacimiento' => 'required|date',
            'informacion_contacto' => 'required|string|max:100',
            'genero' => 'required|in:Masculino,Femenino,Otro',
            'id_puesto_trabajo' => 'required|integer',
            'id_jornadas' => 'required|integer',
            'foto' => 'nullable|binary',
        ]);

        $empleado->update($validated);

        return response()->json($empleado);
    }

    public function destroy($id)
    {
        $empleado = Empleado::find($id);
        if (!$empleado) {
            return response()->json(['error' => 'Empleado no encontrado'], 404);
        }
}
}
