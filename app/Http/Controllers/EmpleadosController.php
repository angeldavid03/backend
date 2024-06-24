<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\PuestoTrabajo;
use App\Models\Jornadas;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;




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

    public function create()
    {
       

        

        
        
          $puestos = PuestoTrabajo::all();
          $jornadas = Jornadas::all();

          $jornadas = $jornadas->mapWithKeys(function ($jornada) {
            return [$jornada->id => $jornada->entrada . ' - ' . $jornada->salida];

            
        });

        $puestos = $puestos->mapWithKeys(function ($puesto) {
            return [$puesto->id => $puesto->nombre];
            });
    

        
        return view('admin.create',compact('puestos', 'jornadas'));

    return response()->json(['success' => 'Empleado guardado exitosamente.']);
    }

    public function store(Request $request)
    {

        $request->validate([
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'direccion' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'informacion_contacto' => 'required|string|max:100|unique:empleados,informacion_contacto',
            'genero' => 'required|in:Masculino,Femenino,Otro',
            'id_puesto_trabajo' => 'required|exists:puestos_trabajo,id', 
            'id_jornadas' => 'required|exists:jornadas,id',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);
       
    
        $data = $request->all();
        $data['codigo_empleado'] = $this->generateCodigoEmpleado();
        $data['created_at'] = Carbon::now();

        
        
        $empleado = Empleado::create($data);
        

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('fotos', 'public');
        }

        
    
        return redirect()->route('admin.empleados.index', $empleado)->with('success', 'Empleado creado exitosamente.');
    }

    private function generateCodigoEmpleado()
    {
        $letters = strtoupper(substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 2));
        $numbers = substr(str_shuffle("0123456789"), 0, 2);
        return $letters . $numbers;
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

    public function edit(Request $request, $id)
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
        return view('admin.empleados.edit',compact('empleados'));
    }

    public function update(Request $request, Empleado $empleado)    
    {

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
