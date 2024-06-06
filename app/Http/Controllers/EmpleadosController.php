<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Empleado;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class empleadoscontroller extends Controller
{
    public function index()
    {
        $empleados = Empleado::with('PuestoTrabajo')->get();
         
        if ($empleados->isEmpty()) {
            return response()->json([
                'message' => 'No hay empleados registrados'
            ], 404);
        }

        return response()->json($empleados);
    }

     public function show($id)
          {
            $empleado = Empleado::with('puestotrabajo')->find($id);
            if (!$empleado){
                return response()->json(['mensaje' => 'No se encontro el empleado'], 404);

            }
            return response()->json($empleado);
          }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'direccion' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'informacion_contacto' => 'required|unique:empleados|string|max:100',
            'genero' => 'required|in:Masculino,Femenino,Otro',
            'id_puesto_trabajo' => 'required|exists:puestos_trabajo,id',
            'foto' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $codigo_empleado = $this->generateCodigoEmpleado();

        $empleado = Empleado::create(array_merge(
            $request->all(),
            ['codigo_empleado' => $codigo_empleado]
        ));

        return response()->json($empleado, 201);
    }

    private function generateCodigoEmpleado()
    {
        $letras = Str::upper(Str::random(2));
        $numeros = rand(10, 99);
        return $letras . $numeros;
    }

    public function validateCodigo(Request $request)
    {
        $codigo_empleado = $request->input('codigo_empleado');

        $empleado = Empleado::where('codigo_empleado', $codigo_empleado)->first();
        if ($empleado) {
            return response()->json(['message' => 'Empleado registrado con éxito', 'success' => true, 'empleado' => $empleado]);
        } else {
            return response()->json(['message' => 'Código de empleado no encontrado', 'success' => false], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $empleado = Empleado::find($id);
        if (!$empleado) {
            return response()->json(['mensaje' => 'No se encontró el empleado'], 404);
        }

        $validator = Validator::make($request->all(), [
            
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'direccion' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'informacion_contacto' => 'required|string|max:100',
            'genero' => 'required|in:Masculino,Femenino,Otro',
            'id_puesto_trabajo' => 'required|exists:puestos_trabajo,id',
            'foto' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $empleado->update($request->all());
        return response()->json($empleado);
    }

    public function destroy($id)
    {
        $empleado = Empleado::find($id);
        if (!$empleado) {
            return response()->json(['mensaje' => 'No se encontro el empleado'], 404);
        }
        $empleado->delete();
        return response()->json(['message' => 'Empleado exterminado, volvere!']);
    }
}
