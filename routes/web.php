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
Route::get('/inicio/{id}', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

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
CLIENTE
==========================================================================================*/
Route::get('clientes/{id}', '\App\Http\Controllers\ClienteController@index')->name('clientes')->middleware(['no-cache']);
Route::get('tabla-clientes', '\App\Http\Controllers\ClienteController@tabla')->name('tabla-clientes');
Route::post('crear-cliente', '\App\Http\Controllers\ClienteController@crear');
Route::get('traer-cliente', '\App\Http\Controllers\ClienteController@traer');
Route::post('eliminar-cliente', '\App\Http\Controllers\ClienteController@eliminar');


/*==========================================================================================
PROYECTOS
==========================================================================================*/
Route::get('proyectos/{id}', '\App\Http\Controllers\ProyectoController@index')->name('proyectos');
Route::get('tabla-proyectos', '\App\Http\Controllers\ProyectoController@tabla')->name('tabla-proyectos');
Route::post('crear-proyecto', '\App\Http\Controllers\ProyectoController@crear');
Route::get('traer-proyecto', '\App\Http\Controllers\ProyectoController@traer');

/*==========================================================================================
PERFILES
==========================================================================================*/
Route::get('perfiles/{id}', '\App\Http\Controllers\PerfilesController@index')->name('perfiles');
Route::get('tabla-perfiles', '\App\Http\Controllers\PerfilesController@tabla')->name('tabla-perfiles');
Route::post('crear-perfil', '\App\Http\Controllers\PerfilesController@crear');
Route::get('traer-perfil', '\App\Http\Controllers\PerfilesController@traer');

/*==========================================================================================
REPORTES
==========================================================================================*/
Route::get('reportes/{id}', '\App\Http\Controllers\ReporteController@index')->name('reportes');


/*==========================================================================================
INCIDENCIAS
==========================================================================================*/
Route::get('incidencias/{id}/{codigo_proyecto?}', '\App\Http\Controllers\IncidenciasController@Index')->name('incidencias');
Route::get('tabla-incidencias', '\App\Http\Controllers\IncidenciasController@tabla')->name('tabla-incidencias');
Route::post('crear-incidencia', '\App\Http\Controllers\IncidenciasController@crearActualizar');
Route::get('incidencia/{codigo_incidencia?}', '\App\Http\Controllers\IncidenciasController@incidencia')->name('incidencia');

Route::post('crear-actualizar-archivos', '\App\Http\Controllers\IncidenciasController@crearActualizarArchivos');
Route::post('eliminar-archivo-incidencia', '\App\Http\Controllers\IncidenciasController@eliminarArchivo');
Route::get('listar-comentarios-incidencia', '\App\Http\Controllers\IncidenciasController@ListarComentarios');
Route::post('crear-actualizar-comentario-incidencia', '\App\Http\Controllers\IncidenciasController@crearActualizarComentario');
Route::get('traer-comentario-incidencia', '\App\Http\Controllers\IncidenciasController@traerComentario');
Route::post('eliminar-comentario-incidencia', '\App\Http\Controllers\IncidenciasController@eliminarComentario');
/*==========================================================================================
USUARIOS
==========================================================================================*/
Route::get('usuarios/{id}', '\App\Http\Controllers\UsuarioController@index')->name('usuarios')->middleware(['no-cache']);
Route::get('tabla-usuarios', '\App\Http\Controllers\UsuarioController@tabla')->name('tabla-usuarios');
Route::post('crear-usuario', '\App\Http\Controllers\UsuarioController@crear');
Route::get('traer-usuario', '\App\Http\Controllers\UsuarioController@traer');
Route::post('eliminar-usuario', '\App\Http\Controllers\UsuarioController@eliminar');

/*==========================================================================================
AJAX GLOBALES
==========================================================================================*/
Route::get('listar-proyectos', '\App\Http\Controllers\AjaxController@listarProyectos');
Route::get('listar-tipo-incidencia', '\App\Http\Controllers\AjaxController@listarTipoIncidencia');
Route::get('listar-staff', '\App\Http\Controllers\AjaxController@listarStaff');
Route::get('listar-staff-autocomplete', '\App\Http\Controllers\AjaxController@listarStaffAutocomplete');
Route::get('listar-cliente-autocomplete', '\App\Http\Controllers\AjaxController@listarClienteAutocomplete');
