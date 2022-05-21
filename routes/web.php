<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/inicio', [App\Http\Controllers\HomeController::class, 'index'])->name('home');




Route::get('/', function () {
    return redirect()->route('login');
});


/*==========================================================================================
                                        AUTENTICACION
==========================================================================================*/
Route::get('inicio-sesion', 'App\Http\Controllers\AutenticacionController@login');
Route::post('autenticar', 'App\Http\Controllers\AutenticacionController@autenticar');
Route::get('registrar', 'App\Http\Controllers\AutenticacionController@registrar');
Route::get('cerrar-sesion', 'App\Http\Controllers\AutenticacionController@cerrarSesion');

/*==========================================================================================
                                        AVATAR
==========================================================================================*/
Route::post('subir-avatar', '\App\Http\Controllers\AvatarController@subirAvatar');
Route::get('listar-avatar', '\App\Http\Controllers\AvatarController@listarAvatar');

/*==========================================================================================
                                        STAFF
==========================================================================================*/
Route::get('listar-staff', '\App\Http\Controllers\StaffController@listarStaff');

/*==========================================================================================
                                        PROYECTOS
==========================================================================================*/
Route::get('proyectos', '\App\Http\Controllers\ProyectoController@index')->name('proyectos');
Route::get('tabla-proyectos', '\App\Http\Controllers\ProyectoController@tabla')->name('tabla-proyectos');
Route::post('crear-proyecto', '\App\Http\Controllers\ProyectoController@crear');

/*==========================================================================================
                                        INCIDENCIAS
==========================================================================================*/
Route::get('incidencias/{id_proyecto?}', '\App\Http\Controllers\IncidenciasController@Index')->name('incidencias');
Route::get('tabla-incidencias', '\App\Http\Controllers\IncidenciasController@tabla')->name('tabla-incidencias');
Route::post('crear-incidencia', '\App\Http\Controllers\IncidenciasController@crear');
