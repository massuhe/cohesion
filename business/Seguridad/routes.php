<?php

Route::resource('roles', 'RolesController');
Route::get('permisos', 'RolesController@getPermisos');
Route::get('testMail', 'RolesController@mail');