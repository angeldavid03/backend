<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\empleadosController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;

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
    Route::get('/empleados', [empleadosController::class, 'index'])->name('empleados.index');
    Route::post('/empleados', [empleadosController::class, 'store'])->name('empleados.store');
    Route::get('empleados/{id}/show', [empleadosController::class, 'show'])->name('empleados.show');
    Route::get('/empleados/{id}/update', [empleadosController::class, 'update'])->name('empleados.update');
    Route::delete('/empleados/{id}/destroy', [empleadosController::class, 'destroy'])->name('empleados.destroy');
});

// Admins
Route::get('admins/admin', [AdminController::class, 'index'])->name('admin.index');
