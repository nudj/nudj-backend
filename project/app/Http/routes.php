<?php


// Define patterns for expected parameters
$router->pattern('id', '([0-9]+)|(me)');


// Default view
Route::get('/', 'HomeController@index');


// Web view
Route::group(['prefix' => '/'], function () {

    Route::get('register/{type}/{hash}', 'Web\WebController@register');
    Route::post('validate', 'Web\WebController@validate');
    Route::post('verify', 'Web\WebController@verify');
    Route::get('job/{jobId}', 'Web\WebController@job');

});


// Admin panel routes
Route::group(['prefix' => 'admin'], function () {


    Route::get('/', 'Admin\AuthController@getLogin');
    Route::get('auth/login', 'Admin\AuthController@getLogin');
    Route::get('auth/logout', 'Admin\AuthController@getLogout');
    Route::post('auth/login', 'Admin\AuthController@postLogin');

    Route::get('/dashboard', 'Admin\DashboardController@index');
    Route::get('/repair', 'Admin\RepairController@index');
    Route::get('/logs', 'Admin\LogsController@index');

    Route::get('/logs/line', 'Admin\LogsController@getLines');

    Route::get('/command/composer/update', 'Admin\CommandsController@composerUpdate');

});

// API v1 routes
Route::group(['prefix' => 'api/v1'], function () {

    Route::get('connect/facebook', 'SocialController@facebook');
    Route::get('connect/linkedin', 'SocialController@linkedin');

    Route::get('elastic/repair', 'SearchEngineController@repair');
    Route::get('cloud/empty', 'CloudController@emptyAllContainers');

    Route::get('config', 'ConfigController@index');
    Route::get('config/{key}', 'ConfigController@show');

    Route::put('devices', 'DevicesController@register');
    Route::post('feedback', 'FeedbackController@send');

    Route::get('notifications', 'NotificationsController@index');
    Route::get('notifications/test', 'NotificationsController@test');
    Route::get('skills/suggest/{term?}', 'SkillsController@suggest');

    Route::get('users', 'UsersController@index');
    Route::get('users/{id}', 'UsersController@show');
    Route::post('users', 'UsersController@store');
    Route::put('users/{id?}', 'UsersController@update');
    Route::delete('users/{id}', 'UsersController@destroy');
    Route::put('users/verify', 'UsersController@verify');
    Route::get('users/exists/{id}', 'UsersController@exists');
    Route::get('users/{id}/contacts', 'UsersController@contacts');
    Route::get('users/{id}/favourites', 'UsersController@favourites');
    Route::put('users/{id}/favourite', 'UsersController@like');
    Route::delete('users/{id}/favourite', 'UsersController@unlike');

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


    Route::get('chat', 'ChatController@index');
    Route::get('chat/archive', 'ChatController@archived');
    Route::put('chat/archive/{id}', 'ChatController@archive');
    Route::delete('chat/archive/{id}', 'ChatController@restore');

    Route::put('chat', 'ChatController@spawn');
    Route::delete('chat/all', 'ChatController@deleteAllRooms');

});


// Listen for some stuff
if (env('APP_ENV') != 'production' && Input::get('debug') == 'sql') {
    Event::listen('illuminate.query', function ($query) {
        echo($query . "\r\n");
    });
}
