<?php

Route::get('clasesEspecificas/listado', 'ClaseEspecificaController@getClasesEspecificas');
Route::post('clases/suspender', 'ClaseController@suspender');
Route::patch('clasesEspecificas/cancelar', 'ClaseEspecificaController@cancelar');
Route::resource('clases', 'ClaseController');
Route::resource('clasesEspecificas', 'ClaseEspecificaController');