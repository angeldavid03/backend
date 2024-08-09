<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class admincontroller extends Controller
{
    public function showProfile()
    {
        // Obtener el administrador autenticado
        $admin = Auth::user(); 

        session(['url.intended' => url()->previous()]);
        return view('admin.profile', compact('admin'));
    }

    public function updateProfile(Request $request)
{
    // Obtener el administrador autenticado
    $admin = Auth::user();

    // Validar los datos del formulario
    $request->validate([
        'username' => 'required|string|max:30',
        'nombre' => 'required|string|max:50',
        'apellido' => 'required|string|max:50',
        'email' => 'required|email|max:100',
        'foto' => 'nullable|image|max:2048',
        'current_password' => 'nullable|current_password', // Validación de contraseña actual
        'new_password' => 'nullable|string|min:10|confirmed'
    ]);

    // Verifica que $admin sea una instancia del modelo Admin
    if ($admin instanceof Admin) {
        // Comparar los datos antiguos con los nuevos datos
        $isUpdated = false;

        // Verificar si los datos han cambiado
        if ($admin->username !== $request->input('username')) {
            $admin->username = $request->input('username');
            $isUpdated = true;
        }
        if ($admin->nombre !== $request->input('nombre')) {
            $admin->nombre = $request->input('nombre');
            $isUpdated = true;
        }
        if ($admin->apellido !== $request->input('apellido')) {
            $admin->apellido = $request->input('apellido');
            $isUpdated = true;
        }
        if ($admin->email !== $request->input('email')) {
            $admin->email = $request->input('email');
            $isUpdated = true;
        }

        // Si hay una foto nueva, procesar y guardar
        if ($request->hasFile('foto')) {
            $admin->foto = file_get_contents($request->file('foto')->getRealPath());
            $isUpdated = true;
        }

        if ($request->filled('current_password') && $request->filled('new_password')) {
            if (Hash::check($request->input('current_password'), $admin->password)) {
                $admin->password = Hash::make($request->input('new_password'));
                $isUpdated = true;
            } else {
                return redirect()->back()->with('error', 'La contraseña actual es incorrecta.');
            }
        }


        // Guardar los cambios si hay actualizaciones
        if ($isUpdated) {
            $admin->save();
            return redirect()->route('admin.empleados.index')->with('success', 'Perfil actualizado con éxito.');
        } else {
            return redirect()->back()->with('info', 'No se realizaron cambios en el perfil.');
        }
    } else {
        return redirect()->back()->with('error', 'No se pudo actualizar el perfil.');
    }
}

    
}
