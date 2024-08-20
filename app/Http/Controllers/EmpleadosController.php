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
        $puestos = PuestoTrabajo::pluck('nombre', 'id');
        $jornadas = Jornadas::all()->mapWithKeys(function ($jornada) {
            return [$jornada->id => $jornada->entrada . ' - ' . $jornada->salida];
        })->toArray();

        // Retornar la vista con los datos
        return view('admin.create', compact('puestos', 'jornadas'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'direccion' => 'required|string|max:70',
            'fecha_nacimiento' => 'required|date',
            'informacion_contacto' => 'required|string|max:70|unique:empleados,informacion_contacto',
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
            // Guarda la foto en el disco público y obtiene el nombre del archivo
            $fotoPath = $request->file('foto')->store('fotos', 'public');
            // Actualiza el campo 'foto' en la base de datos
            $empleado->foto = $fotoPath;
            $empleado->save();
        }

        
    
        return redirect()->route('admin.empleados.index', $empleado)->with('success', 'Empleado registrado exitosamente.');
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

    public function edit(Empleado $empleado, $id)
    {
        $empleado = Empleado::find($id);
    if (!$empleado) {
        return response()->json(['mensaje' => 'No se encontró el empleado'], 404);
    }

    $puestos = PuestoTrabajo::all();
    $jornadas = Jornadas::all();

    $jornadas = $jornadas->mapWithKeys(function ($jornada) {
        return [$jornada->id => $jornada->entrada . ' - ' . $jornada->salida];
    });

    $puestos = $puestos->mapWithKeys(function ($puesto) {
        return [$puesto->id => $puesto->nombre];
    });

    return view('admin.edit', compact('empleado', 'puestos', 'jornadas'));
    }

    public function update(Empleado $empleado, Request $request, $id)    
    {
        $empleado = Empleado::find($id);
        if (!$empleado) {
        return response()->json(['mensaje' => 'No se encontró el empleado'], 404);
    }

    $request->validate([
        'nombre' => 'required|string|max:50',
        'apellido' => 'required|string|max:50',
        'direccion' => 'required|string|max:255',
        'fecha_nacimiento' => 'required|date',
        'informacion_contacto' => 'required|string|max:100|unique:empleados,informacion_contacto,' . $empleado->id,
        'genero' => 'required|in:Masculino,Femenino,Otro',
        'id_puesto_trabajo' => 'required|exists:puestos_trabajo,id',
        'id_jornadas' => 'required|exists:jornadas,id',
        'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
    ]);

    $data = $request->all();

    if ($request->hasFile('foto')) {
        if ($empleado->foto) {
            Storage::delete('public/' . $empleado->foto);
        }
        $data['foto'] = $request->file('foto')->store('fotos', 'public');
    }

    $empleado->update($data);

    return redirect()->route('admin.empleados.index', $empleado)->with('success', 'Empleado actualizado exitosamente.');

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
        return redirect()->route('admin.empleados.index')->with('success', 'Empleado eliminado correctamente') ;
    }

    public function confirmDelete($id)
{
    $empleado = Empleado::find($id);
    if (!$empleado) {
        return redirect()->route('admin.empleados.index')->with('error', 'Empleado no encontrado');
    }
    return view('admin.delete', compact('empleado'));
}

}
