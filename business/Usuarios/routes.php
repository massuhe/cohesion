<?php

Route::resource('usuarios', 'UsuarioController');
Route::get('alumnos', 'AlumnoController@listado');
Route::get('reporte', 'AlumnoController@reporteIngresos');