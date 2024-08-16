<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PuestoTrabajo;

class PuestoTrabajoController extends Controller
{
    public function index()
    {
        $puestos = PuestoTrabajo::all();
        return view('admin.categorias', compact('puestos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $puesto = new PuestoTrabajo();
        $puesto->nombre = $request->nombre;
        $puesto->save();

        return redirect()->route('admin.puestos.index')->with('success', 'Puesto de trabajo creado correctamente.');
    }

    public function update(Request $request, $id)
    {
        // Obtener el puesto de trabajo actual
        $puesto = PuestoTrabajo::findOrFail($id);
    
        // Validar el formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);
    
        // Comparar los valores
        if ($puesto->nombre === $request->input('nombre')) {
            return redirect()->route('admin.puestos.index')
                ->with('info', 'No se realizaron cambios en el puesto de trabajo.');
        }
    
        // Si hay cambios, actualizar el puesto
        $puesto->update([
            'nombre' => $request->input('nombre'),
        ]);
    
        return redirect()->route('admin.puestos.index')
            ->with('success', 'Puesto de trabajo actualizado correctamente.');
    }

    public function destroy($id)
{
    $puesto = PuestoTrabajo::findOrFail($id);
    $puesto->delete();

    return redirect()->route('admin.puestos.index')->with('success', 'Puesto de trabajo eliminado correctamente.');
}



}
