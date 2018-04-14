<?php

Route::resource('cuota', 'CuotaController');
Route::get('cuota/{alumno}/{mes}/{anio}', 'CuotaController@findWithFallback');
Route::get('pagos', 'PagoController@getListado');
