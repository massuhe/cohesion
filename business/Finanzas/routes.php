<?php

Route::resource('cuota', 'CuotaController');
Route::get('cuota/{alumno}/{mes}/{anio}', 'CuotaController@findWithFallback');
Route::get('pagos/cuota/{mes}/{anio}', 'PagoController@getByMesCuota');
Route::get('pagos/searchAlumnoFechas', 'PagoController@getByAlumnoYFechas');
