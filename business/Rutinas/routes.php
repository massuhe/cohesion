<?php

Route::get('rutina', 'RutinaController@getByAlumno');
Route::get('alumnos/{idAlumno}/rutina', 'RutinaController@getByAlumno');
Route::post('rutinas/cargarDetalles', 'RutinaController@cargarDetallesRutina');
Route::post('rutinas/{idAlumno}/cargarDetalles', 'RutinaController@cargarDetallesRutina');
Route::resource('rutinas', 'RutinaController');