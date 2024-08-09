<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\empleadosController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\jornadascontroller;

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
    Route::get('/empleados', [empleadosController::class, 'index'])->name('admin.empleados.index');
    Route::get('/empleados/create', [empleadosController::class, 'create'])->name('admin.create');
    Route::post('/empleados/store', [empleadosController::class, 'store'])->name('admin.empleados.store');
    Route::get('empleados/{id}/show', [empleadosController::class, 'show'])->name('admin.empleados.show');
    Route::get('/empleados/{id}/edit', [empleadosController::class, 'edit'])->name('admin.edit');
    Route::put('/empleados/{id}', [empleadosController::class, 'update'])->name('admin.empleados.update');
    Route::get('/empleados/{id}/confirmDelete', [EmpleadosController::class, 'confirmDelete'])->name('admin.empleados.confirmDelete');
    Route::delete('/empleados/{id}/destroy', [empleadosController::class, 'destroy'])->name('admin.empleados.destroy');
});

//horarios
Route::get('/admin/horarios', [jornadascontroller::class, 'index'])->name('admin.jornadas.index');
Route::post('/admin/jornadas/store', [JornadasController::class, 'store'])->name('admin.jornadas.store');

Route::get('/admin/jornadas/{id}/edit', [JornadasController::class, 'edit'])->name('admin.jornadas.edit');
Route::put('/admin/jornadas/{id}', [JornadasController::class, 'update'])->name('admin.jornadas.update');

Route::delete('/admin/jornadas/{id}', [JornadasController::class, 'destroy'])->name('admin.jornadas.destroy');






// Admins
Route::middleware('auth')->group(function () {
    Route::get('/admin/profile', [AdminController::class, 'showProfile'])->name('admin.profile');
    Route::post('/admin/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
});  
