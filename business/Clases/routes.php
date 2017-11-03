<?php

Route::get('clasesEspecificas/listado', 'ClaseEspecificaController@getClasesEspecificas');
Route::resource('clases', 'ClaseController');
Route::resource('clasesEspecificas', 'ClaseEspecificaController');