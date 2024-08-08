<?php

namespace App\Http\Controllers;
use App\Models\Jornadas;
use Illuminate\Http\Request;

class jornadascontroller extends Controller
{
    public function index()
    {
        // Obtener todas las jornadas
        $jornadas = Jornadas::all();

        // Retornar la vista con las jornadas
        return view('admin.horarios', compact('jornadas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'entrada' => 'required|date_format:H:i',
            'salida' => 'required|date_format:H:i|after:entrada',
        ]);

        Jornadas::create($request->all());

        return redirect()->route('admin.jornadas.index')->with('success', 'Jornada creada exitosamente.');
    }

    public function edit($id)
    {
        $jornada = Jornadas::findOrFail($id);
        return view('admin.jornadas.edit', compact('jornada'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'entrada' => 'required|date_format:H:i',
            'salida' => 'required|date_format:H:i|after:entrada',
        ]);

        $jornada = Jornadas::findOrFail($id);
        $jornada->update($request->all());

        return redirect()->route('admin.jornadas.index')->with('success', 'Jornada actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $jornada = Jornadas::findOrFail($id);
        $jornada->delete();
    
        return redirect()->route('admin.jornadas.index')->with('success', 'Jornada eliminada exitosamente.');
    }

}
