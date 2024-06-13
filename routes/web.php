<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\empleadoscontroller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\admincontroller;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});




Auth::routes();



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->group(function () {
    Route::get('empleados', [EmpleadosController::class, 'index'])->name('empleados.index');
    Route::get('empleados/datatables', [EmpleadosController::class, 'getDataTables'])->name('empleados.datatables');
    Route::post('empleados/store', [EmpleadosController::class, 'store'])->name('empleados.store');
    Route::get('empleados/{id}/show', [EmpleadosController::class, 'show'])->name('empleados.show');
    Route::put('empleados/update/{id}', [EmpleadosController::class, 'update'])->name('empleados.update');
    Route::delete('empleados/destroy/{id}', [EmpleadosController::class, 'destroy'])->name('empleados.destroy');
});

//admins
Route::get('admins/admin', [admincontroller::class, 'index'])->name('admin.index');

