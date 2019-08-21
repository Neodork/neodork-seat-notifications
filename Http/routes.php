<?php

Route::group([
    'namespace' => 'Neodork\SeatNotifications\Http\Controllers',
], function () {

    // Http Routes to the SeAT API itself
    Route::group([
        'namespace' => 'Api',
        'middleware' => ['api.request', 'api.auth'],
        'prefix' => 'api',
    ], function () {

        // The version 2 API :D
        Route::group(['namespace' => 'v2', 'prefix' => 'v2'], function () {

            Route::group(['prefix' => 'notification/character'], function () {
                Route::post('/group/update/', 'NotificationCharacterController@updateNotificationGroup');
            });

            Route::group(['prefix' => 'search'], function () {
                Route::get('/character/{name}', 'SearchController@searchCharacter');
            });
        });

    });
});
