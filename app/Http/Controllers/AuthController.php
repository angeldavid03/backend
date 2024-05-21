<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function validarConexion()
    {
     try {
        $admin = DB::table('admin')->first();

        if ($admin) {
            return response()->json(['message' => 'conexion exitosa'], 200);
        }else {
            return response()->json(['message' => 'no se encontro el administrador'], 404);
        }

     } catch (\exception $e){
            return response()->json(['message' => 'error al conectar la base de datos'], 500);
        }

     } 
     
}  
