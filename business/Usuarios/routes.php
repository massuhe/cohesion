<?php

Route::resource('usuarios', 'UsuarioController');
Route::get('perfil', 'UsuarioController@show');
Route::put('perfil', 'UsuarioController@update');
Route::put('usuarios/{idUsuario}/contrasena', 'UsuarioController@changePassword');
Route::put('contrasena', 'UsuarioController@changePassword');
Route::get('alumnos', 'AlumnoController@listado');
Route::get('reporte', 'AlumnoController@reporteIngresos');