<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
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

Route::middleware(['no-cache'])->group(function () {
        Auth::routes();
});


Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/inicio', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', function () {
    return redirect()->route('login');
});

/*==========================================================================================
AUTENTICACION
==========================================================================================*/
Route::post('autenticar', 'App\Http\Controllers\AutenticacionController@autenticar');
Route::post('registrar', 'App\Http\Controllers\AutenticacionController@registrar');
Route::get('cerrar-sesion', 'App\Http\Controllers\AutenticacionController@cerrarSesion');

/*==========================================================================================
AVATAR
==========================================================================================*/
Route::post('subir-avatar', '\App\Http\Controllers\AvatarController@subirAvatar');
Route::get('listar-avatar', '\App\Http\Controllers\AvatarController@listarAvatar');

/*==========================================================================================
PROYECTOS
==========================================================================================*/
Route::get('proyectos', '\App\Http\Controllers\ProyectoController@index')->name('proyectos');
Route::get('tabla-proyectos', '\App\Http\Controllers\ProyectoController@tabla')->name('tabla-proyectos');
Route::post('crear-proyecto', '\App\Http\Controllers\ProyectoController@crear');

/*==========================================================================================
PERFILES
==========================================================================================*/
Route::get('perfiles', '\App\Http\Controllers\PerfilesController@index')->name('perfiles');
Route::get('tabla-perfiles', '\App\Http\Controllers\PerfilesController@tabla')->name('tabla-perfiles');
Route::post('crear-perfil', '\App\Http\Controllers\PerfilesController@crear');
Route::get('traer-perfil', '\App\Http\Controllers\PerfilesController@traer');

/*==========================================================================================
INCIDENCIAS
==========================================================================================*/
Route::get('incidencias/{codigo_proyecto?}', '\App\Http\Controllers\IncidenciasController@Index')->name('incidencias');
Route::get('tabla-incidencias', '\App\Http\Controllers\IncidenciasController@tabla')->name('tabla-incidencias');
Route::post('crear-incidencia', '\App\Http\Controllers\IncidenciasController@crear');
Route::get('incidencia/{codigo_incidencia?}', '\App\Http\Controllers\IncidenciasController@incidencia')->name('incidencia');


/*==========================================================================================
USUARIOS
==========================================================================================*/
Route::get('usuarios', '\App\Http\Controllers\UsuarioController@index')->name('usuarios')->middleware(['no-cache']);
Route::get('tabla-usuarios', '\App\Http\Controllers\UsuarioController@tabla')->name('tabla-usuarios');
Route::post('crear-usuario', '\App\Http\Controllers\UsuarioController@crear');
Route::get('traer-usuario', '\App\Http\Controllers\UsuarioController@traer');

/*==========================================================================================
AJAX GLOBALES
==========================================================================================*/
Route::get('listar-proyectos', '\App\Http\Controllers\AjaxController@listarProyectos');
Route::get('listar-tipo-incidencia', '\App\Http\Controllers\AjaxController@listarTipoIncidencia');
Route::get('listar-staff', '\App\Http\Controllers\AjaxController@listarStaff');
Route::get('listar-staff-autocomplete', '\App\Http\Controllers\AjaxController@listarStaffAutocomplete');
