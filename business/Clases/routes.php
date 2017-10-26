<?php

Route::get('clases/especificas', 'ClaseController@getClasesEspecificas');
Route::resource('clases', 'ClaseController');