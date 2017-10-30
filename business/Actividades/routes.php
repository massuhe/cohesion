<?php

Route::get('actividades/horasLimites', 'ActividadController@getActividadesHorasLimites');
Route::resource('actividades', 'ActividadController');