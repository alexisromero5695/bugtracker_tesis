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

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
/* STAFF */
Route::get('get-staffs', '\App\Http\Controllers\StaffController@GetStaffs');

/* PROYECTOS */
Route::get('projects', '\App\Http\Controllers\ProjectController@Index')->name('projects');
Route::get('table-projects', '\App\Http\Controllers\ProjectController@Table')->name('table-projects');
Route::post('create-project', '\App\Http\Controllers\ProjectController@Create');
/* INCIDENCIAS */
Route::get('issues/{project_id?}', '\App\Http\Controllers\IssueController@Index')->name('issues');
Route::get('table-issues', '\App\Http\Controllers\IssueController@Table')->name('table-issues');
Route::post('create-issue', '\App\Http\Controllers\IssueController@Create');
/* AVATAR */
Route::post('upload-avatar', '\App\Http\Controllers\AvatarController@UploadAvatar');
Route::get('get-avatars', '\App\Http\Controllers\AvatarController@GetAvatars');
