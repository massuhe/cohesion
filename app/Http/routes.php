<?php

Route::group(['middleware' => 'cors'], function () {
    Route::post('/login', 'Auth\LoginController@login');
    Route::post('/usuarioLogueado', 'Auth\LoginController@getAuthenticatedUser');
});