<?php

Route::get('clasesEspecificas/listado', 'ClaseEspecificaController@getClasesEspecificas');
Route::get('clases/conAsistencias', 'ClaseController@getConAsistencias');
Route::post('clases/suspender', 'ClaseController@suspender');
Route::patch('clasesEspecificas/cancelar', 'ClaseEspecificaController@cancelar');
Route::resource('clases', 'ClaseController');
Route::resource('clasesEspecificas', 'ClaseEspecificaController');