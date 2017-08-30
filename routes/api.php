<?php

use Illuminate\Http\Request;
use App\Models\Usuario;

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

Route::group(['middleware' => 'cors'], function () {
    Route::post('/login', 'Auth\LoginController@login');
    Route::post('/usuarioLogueado', 'Auth\LoginController@getAuthenticatedUser');
});


/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::resource('usuarios', 'UsuarioController');
Route::resource('alumnos', 'AlumnoController');

/*
Route::get('users', function () {
    return Usuario::with('alumno')->get();
});

Route::get('users/{id}', function ($id) {
    return Usuario::with('alumno')->find($id);
});*/