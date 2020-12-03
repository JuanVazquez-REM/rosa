<?php

use App\Http\Middleware\ValidaEdad;
use App\Http\Middleware\ValidaRol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('registroPersona','PersonaController@regPerson')->middleware('validaEdad');
Route::post('registroUser','UserController@regUser')->middleware('enviar.correos');
Route::get('verificacion/{correo}','UserController@verificar');
Route::post('login','UserController@logueo');
Route::post('archivos','FileController@subida_archivo')->middleware('auth:sanctum');
Route::post('archivo/enviar','FileController@subidas');

Route::middleware('auth:sanctum')->delete('cerrarSesion','UserController@cerrarSesion');
Route::middleware(['auth:sanctum','validaRol'])->group(function(){
Route::get('consulta','UserController@mostrarUser');

Route::post('prueba/token','UserController@prueba')->middleware('auth:sanctum');
});