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
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'direccion' => 'required|string',
            'fecha_nacimiento' => 'required|date',
            'informacion_contacto' => 'required|string|max:100',
            'genero' => 'required|in:Masculino,Femenino,Otro',
            'id_puesto_trabajo' => 'required|exists:puestos_trabajo,id',
            'id_jornadas' => 'required|exists:jornadas,id',
            'foto' => 'nullable|binary',
        ]);

        

        

        // Generar el código del empleado
        $codigo_empleado = $this->generateEmployeeCode();

        // Crear el nuevo empleado
        $empleado = Empleado::create(array_merge($validated, ['codigo_empleado' => $codigo_empleado]));

        return response()->json([
            'message' => 'Empleado creado exitosamente.',
            'empleado' => $empleado
        ], 201);
    }

    private function generateEmployeeCode()
    {
        $letters = strtoupper(substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 2));
        $numbers = rand(10, 99);
        return $letters . $numbers;
    }
    

    public function update(Request $request, $id)
    {
        // Validar los datos entrantes
        $request->validate([
            'nombre' => 'sometimes|required|string|max:50',
            'apellido' => 'sometimes|required|string|max:50',
            'direccion' => 'sometimes|required|string',
            'fecha_nacimiento' => 'sometimes|required|date',
            'informacion_contacto' => 'sometimes|required|string|max:100',
            'genero' => 'sometimes|required|in:Masculino,Femenino,Otro',
            'id_puesto_trabajo' => 'sometimes|required|exists:puestos_trabajo,id',
            'id_jornadas' => 'sometimes|required|exists:jornadas,id',
        ]);

        $empleado = Empleado::findOrFail($id);

        // Obtener los campos que han cambiado
        $updatedFields = [];

        foreach ($request->all() as $key => $value) {
            if ($empleado[$key] != $value) {
                $empleado->$key = $value;
                $updatedFields[] = $key;
            }
        }

        if (!empty($updatedFields)) {
            $empleado->save();
            // Recargar el modelo para asegurarse de obtener los datos más recientes
            $empleado->refresh();
            
            return response()->json([
                'message' => 'Empleado actualizado exitosamente.',
                'campos actualizados' => $updatedFields,
                'empleado' => $empleado
            ]);
        } else {
            return response()->json(['message' => 'No se realizaron cambios en el empleado.'], 200);
        }
    
    }
    

    public function destroy($id)
{
    $empleado = Empleado::findOrFail($id);
    $empleado->delete();

    return response()->json([
        'message' => 'Empleado eliminado exitosamente.'
    ]);
}

}
