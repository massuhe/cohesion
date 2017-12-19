<?php

Route::group([
        // 'middleware' => 'api',
        'namespace' => 'Auth',
        //'prefix' => 'auth'
    ], function () {
    Route::post('/login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout');
    // Route::post('refresh', 'LoginController@refresh');
});