<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\empleadoscontroller;
use App\Http\Controllers\admincontroller;
use App\Http\Controllers\empleadoscontroller2;
use KitLoong\MigrationsGenerator\Schema\Models\Index;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//admins
Route::get('/admins',[admincontroller::class,'index']);
Route::get('/admins/{id}',[admincontroller::class,'show']);
Route::post('/admins',[admincontroller::class,'store']);
Route::put('/admins/{id}',[admincontroller::class,'update']);
Route::delete('/admins/{id}',[admincontroller::class,'destroy']);


//empleados
Route::get('/empleados',[empleadoscontroller2::class, 'index']);
Route::get('/empleados/{id}',[empleadoscontroller2::class, 'show']);
Route::post('/empleados',[empleadoscontroller2::class, 'store']);
Route::put('/empleados/{id}',[empleadoscontroller2::class, 'update']);
Route::delete('/empleados/{id}',[empleadoscontroller2::class, 'destroy']);
