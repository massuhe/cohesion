<?php

Route::get('clasesEspecificas/listado', 'ClaseEspecificaController@getClasesEspecificas');
Route::patch('clasesEspecificas/cancelar', 'ClaseEspecificaController@cancelar');
Route::resource('clases', 'ClaseController');
Route::resource('clasesEspecificas', 'ClaseEspecificaController');