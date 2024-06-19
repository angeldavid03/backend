<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\PuestoTrabajo;
use App\Models\Jornadas;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EmpleadosController extends Controller
{
    public function index()
    {
        $empleados = Empleado::with('puestoTrabajo', 'jornadas')->get();
        $puestos = PuestoTrabajo::all();
        $jornadas = Jornadas::all();
        return view('admin.empleados', compact('empleados', 'puestos', 'jornadas'));
    }

    public function show($id)
    {
        $empleado = Empleado::with('puestoTrabajo')->find($id);
        if (!$empleado) {
            return response()->json(['mensaje' => 'No se encontró el empleado'], 404);
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
            'nombre_puesto_trabajo' => 'required|exists:puesto_trabajos,nombre',
            'id_jornadas' => 'required|exists:jornadas,id',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $codigo_empleado = $this->generateCodigoEmpleado();
        $data = $request->all();
        $data['codigo_empleado'] = $codigo_empleado;

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('fotos', 'public');
        }

        Empleado::updateOrCreate(['id' => $request->empleado_id], $data);
        return response()->json(['success' => 'Empleado guardado exitosamente.']);
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
            'informacion_contacto' => 'required|string|max:100|unique:empleados,informacion_contacto,' . $empleado->id,
            'genero' => 'required|in:Masculino,Femenino,Otro',
            'nombre_puesto_trabajo' => 'required|exists:puesto_trabajos,nombre',
            'id_jornadas' => 'required|exists:jornadas,id',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $request->all();

        if ($request->hasFile('foto')) {
            if ($empleado->foto) {
                Storage::delete('public/' . $empleado->foto);
            }
            $data['foto'] = $request->file('foto')->store('fotos', 'public');
        }

        $empleado->update($data);
        return response()->json(['success' => 'Empleado actualizado exitosamente.']);
    }

    public function destroy($id)
    {
        $empleado = Empleado::find($id);
        if (!$empleado) {
            return response()->json(['mensaje' => 'No se encontró el empleado'], 404);
        }

        if ($empleado->foto) {
            Storage::delete('public/' . $empleado->foto);
        }

        $empleado->delete();
        return response()->json(['message' => 'Empleado eliminado correctamente']);
    }
}
