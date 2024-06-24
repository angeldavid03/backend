<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Admin;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class admincontroller extends Controller
{
    public function index()
    {
        $admin = Admin::all();
        if ($admin->isEmpty()) {
            return response()->json([
                'message' => 'No hay admins registrados'
            ], 404);
        }
        return response()->json($admin);
        
    }

    public function show($id)
    {
        $admin = Admin::find($id);

        if (!$admin) {
            return response()->json(['mensaje' => 'No se encontro el administrador'], 404);
        }

        return response()->json($admin);
    }

    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:30',
            'password' => 'required|string|min:6',
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'email' => 'required|email|max:100|unique:admin,email',
            'foto' => 'nullable|image|max:2048',
        ]); 

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $admin = Admin::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'foto' => $request->foto,
        ]);

        return response()->json($admin, 201);
    }


    public function update(Request $request, $id)
    {
        $admin = Admin::find($id);

        if (!$admin) {
            return response()->json(['mensaje' => 'No se encontró el administrador'], 404);
        }

        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:30',
            'password' => 'nullable|string|min:6',
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'email' => 'required|email|max:100|unique:admin,email,' . $admin->id,
            'foto' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $admin->username = $request->username;
        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }
        $admin->nombre = $request->nombre;
        $admin->apellido = $request->apellido;
        $admin->email = $request->email;
        $admin->foto = $request->foto;
        $admin->save();

        return response()->json($admin);
    }

    public function destroy($id)
    {
        $admin = Admin::find($id);

        if (!$admin) {
            return response()->json(['mensaje' => 'No se encontró el administrador'], 404);
        }

        $admin->delete();

        return response()->json(['mensaje' => 'Administrador exterminado, volvere!']);
    }
}
