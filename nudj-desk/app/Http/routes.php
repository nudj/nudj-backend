<?php

// -------------------------------------------------------------------------------
// Define patterns for expected parameters
$router->pattern('id', '([0-9]+)');
$router->pattern('userid', '([0-9]+)|(me)');
$router->pattern('filter', '([a-z]+)');

// -------------------------------------------------------------------------------
// ADMINISTRATION

Route::group(['prefix' => '/'], function() {

    // AUTHENTICATION
    Route::get('auth/login', 'Desk\Auth\AuthController@getLogin');
    Route::post('auth/login', 'Desk\Auth\AuthController@postLogin');
    Route::get('auth/logout', 'Desk\Auth\AuthController@getLogout');

    // DASHBOARD
    Route::get('/', 'Desk\DashboardController@index');
    Route::get('dashboard', 'Desk\DashboardController@index');

    // USERS
    Route::get('/users', 'Desk\UsersController@index');
    Route::get('/users/{id}', 'Desk\UsersController@show');

    // JOBS
    Route::get('/jobs', 'Desk\JobsController@index');
    Route::get('/jobs/{id}', 'Desk\JobsController@show');

    // ADMINS
    Route::get('/admins', 'Desk\AdminsController@index');
    Route::get('/admins/create', 'Desk\AdminsController@create');
    Route::post('/admins', 'Desk\AdminsController@store');
    Route::get('/admins/{id}', 'Desk\AdminsController@show');
    Route::post('/admins/{id}', 'Desk\AdminsController@update');

    // DATATABLES
    Route::get('/datatables/{who}', 'Desk\DeskController@tableData');

});

// -------------------------------------------------------------------------------
// Listen for some stuff
if (env('APP_ENV') != 'production' && Input::get('debug') == 'sql') {
    Event::listen('illuminate.query', function ($query) {
        echo($query . "\r\n");
    });
}
