<?php

$router->pattern('id', '([0-9]+)|(me)');


Route::group(['prefix' => 'api/v1'], function() {

    Route::put('elastic/repair', 'SearchEngineController@repair');

    Route::get('config', 'ConfigController@index');
    Route::get('config/{key}', 'ConfigController@show');

    Route::get('notifications', 'NotificationsController@index');
    Route::get('skills/suggest/{term?}', 'SkillsController@suggest');

    Route::get('users', 'UsersController@index');
    Route::get('users/{id}', 'UsersController@show');
    Route::post('users', 'UsersController@store');
    Route::put('users/{id?}', 'UsersController@update');
    Route::delete('users/{id}', 'UsersController@destroy');
    Route::put('users/verify', 'UsersController@verify');
    Route::get('users/{id}/contacts', 'UsersController@contacts');
    Route::get('users/{id}/favourites', 'UsersController@favourites');

    Route::get('contacts', 'ContactsController@index');
    Route::put('contacts/{id}', 'ContactsController@update');
    Route::delete('contacts/{id}', 'ContactsController@destroy');


    Route::get('jobs', 'JobsController@index');
    Route::get('jobs/{id}', 'JobsController@show');
    Route::post('jobs', 'JobsController@store');
    Route::put('jobs/{id}', 'JobsController@update');
    Route::delete('jobs/{id}', 'JobsController@destroy');
    Route::put('jobs/{id}/like', 'JobsController@like');
    Route::delete('jobs/{id}/like', 'JobsController@unlike');

});



Event::listen('illuminate.query', function($query)
{
    if(env('APP_ENV') != 'production' && Input::get('debug') == 'sql') {
        echo($query . "\r\n");
    }
});