<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PuestoTrabajo;

class PuestoTrabajoController extends Controller
{
    public function index()
    {
        $puestos = PuestoTrabajo::all();
    }
}
