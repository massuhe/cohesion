<?php

Route::resource('cuota', 'CuotaController');
Route::get('cuota/{mes}/{anio}', 'CuotaController@getByMesAnio');
Route::get('cuota/{alumno}/{mes}/{anio}', 'CuotaController@findWithFallback');
Route::get('movimientos/{mes}/{anio}', 'MovimientoController@findOrReturnLatest');
Route::post('movimientos/{mes}/{anio}', 'MovimientoController@storeOrUpdateMany');