<?php

Route::get('actividades/horasLimites', 'ActividadController@getActividadesHorasLimites');
Route::get('actividades/listado', 'ActividadController@getListado');
Route::resource('actividades', 'ActividadController');