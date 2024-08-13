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
        'current_password' => 'nullable|string',
        'new_password' => 'nullable|string|', // Se ajusta a mínimo 8 caracteres
    ]);

    // Verifica que $admin sea una instancia del modelo Admin
    if ($admin instanceof Admin) {
        $updated = false; // Indicador de si se realizaron cambios

        // Verifica la contraseña actual
        if ($request->filled('current_password') && !Hash::check($request->current_password, $admin->password)) {
            return redirect()->back()->with('error', 'La contraseña actual es incorrecta.');
        }

        // Actualizar los campos de perfil si hay cambios
        $data = $request->only('username', 'nombre', 'apellido', 'email');

        if ($request->hasFile('foto')) {
            $data['foto'] = file_get_contents($request->file('foto')->getRealPath());
        }

        // Verifica si hay cambios en los datos del perfil
        if ($admin->fill($data)->isDirty()) {
            $admin->save();
            $updated = true;
        }

        // Actualizar la contraseña si se proporciona una nueva
        if ($request->filled('new_password')) {
            $admin->password = Hash::make($request->new_password); // Hashea la nueva contraseña
            $admin->save();
            $updated = true;
        }

          // Redirige a la página deseada después de la actualización
          if ($updated) {
            return redirect()->route('admin.empleados.index')->with('success', 'Perfil actualizado con éxito.');
        } else {
            return redirect()->back()->with('info', 'No se realizaron cambios en el perfil.');
        }
    } else {
        return redirect()->back()->with('error', 'No se pudo actualizar el perfil.');
    }
 }
}
