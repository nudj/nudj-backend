<?php

// -------------------------------------------------------------------------------
// Define patterns for expected parameters
$router->pattern('id', '([0-9]+)');
$router->pattern('userid', '([0-9]+)|(me)');
$router->pattern('filter', '([a-z]+)');


// -------------------------------------------------------------------------------
// Default view
// This route is being superseded by the Admin section
Route::get('/', 'Web\HomeController@index');


// -------------------------------------------------------------------------------
// Web view
// This route is being superseded by the Admin section
Route::group(['prefix' => '/'], function () {

    Route::get('register/{type}/{hash}', 'Web\WebController@login');

    Route::post('validate', 'Web\WebController@validate');
    Route::get('job/{jobId}/{hash?}', 'Web\WebController@job');

    Route::post('verify', 'Web\ActionsController@verify');
    Route::post('apply', 'Web\ActionsController@apply');
    Route::post('refer', 'Web\ActionsController@nudge');
    Route::get('countries', 'Web\ActionsController@countries');

    Route::get('download', 'Web\WebController@download');

});


// -------------------------------------------------------------------------------
// HTML sources accessed from the app
Route::group(['prefix' => 'html'], function () {
    Route::get('terms', 'HtmlController@terms');
    Route::get('privacy', 'HtmlController@privacy');
    Route::get('cookies', 'HtmlController@cookies');
});


// -------------------------------------------------------------------------------
// API V1 routes
/*

	Note: All the controllers in the api/v1 group inherit from ApiController, which specifies that
	the only "non token methods" are:

		'App\Http\Controllers\UsersController@store',
		'App\Http\Controllers\UsersController@verify',
		'App\Http\Controllers\UsersController@exists',
		'App\Http\Controllers\CountriesController@index',
		'App\Http\Controllers\ServicesController@test',

	They correspond to
		Route::post('users', 'UsersController@store');
		Route::put('users/verify', 'UsersController@verify');
		Route::get('users/exists/{userid}', 'UsersController@exists');
		Route::get('countries', 'CountriesController@index');
		Route::get('services/test', 'ServicesController@test');

	If a route is not "non token" then it must Shield::validate()

*/
Route::group(['prefix' => 'api/v1'], function () {

    // JOBS
    Route::get('jobs/search/{term?}', 'JobsController@search');
    Route::get('jobs/{filter}', 'JobsController@index');
    Route::get('jobs/{id}', 'JobsController@show');
    Route::post('jobs', 'JobsController@store');
    Route::put('jobs/{id}', 'JobsController@update');
    Route::delete('jobs/{id}', 'JobsController@destroy');
    Route::put('jobs/{id}/like', 'JobsController@like');
    Route::delete('jobs/{id}/like', 'JobsController@unlike');

    // USERS
    Route::get('users', 'UsersController@index');
    Route::get('users/{userid}', 'UsersController@show');
    Route::post('users', 'UsersController@store');
    Route::put('users/{userid?}', 'UsersController@update');
    Route::delete('users/{userid}', 'UsersController@destroy');
    Route::put('users/verify', 'UsersController@verify');
    Route::get('users/exists/{userid}', 'UsersController@exists');
    Route::get('users/{userid}/contacts', 'UsersController@contacts');
    Route::get('users/{userid}/favourites', 'UsersController@favourites');
    Route::put('users/{userid}/favourite', 'UsersController@favourite');
    Route::delete('users/{userid}/favourite', 'UsersController@unfavourite');

    // NUDGE
    Route::put('nudge', 'NudgeController@nudge');
    Route::put('nudge/ask', 'NudgeController@ask');
    Route::put('nudge/apply', 'NudgeController@apply');
    Route::put('nudge/chat', 'NudgeController@chat');

    // CONTACTS
    Route::get('contacts/mine', 'ContactsController@index');
    Route::put('contacts/{id}', 'ContactsController@update');
    Route::delete('contacts/{id}', 'ContactsController@destroy');
    Route::post('contacts/{id}/invite', 'ContactsController@invite');

    // CHAT
    Route::get('chat/{filter}', 'ChatController@index');
    Route::get('chat/{id}', 'ChatController@show');
    Route::delete('chat/{id}', 'ChatController@destroy');
    Route::put('chat/{id}/archive', 'ChatController@archive');
    Route::delete('chat/{id}/archive', 'ChatController@restore');
    Route::put('chat/{id}/mute', 'ChatController@mute');
    Route::delete('chat/{id}/mute', 'ChatController@unmute');
    Route::put('chat/notification', 'ChatController@notify');
    Route::put('chat', 'ChatController@spawn');
    Route::delete('chat/all', 'ChatController@deleteAllRooms');

    // NOTIFICATION
    Route::get('notifications', 'NotificationsController@index');
    Route::put('notifications/{id}/read', 'NotificationsController@read');

    // SOCIAL
    Route::put('connect/facebook', 'SocialController@facebook');
    Route::delete('connect/facebook', 'SocialController@disconnectFacebook');

    // ---------------------------------------------------------------------
    // TODO: The below is commented out waiting to be deleted
    // Route::put('connect/linkedin', 'SocialController@linkedin');
    // Route::delete('connect/linkedin', 'SocialController@disconnectLinkedIn');
    // ---------------------------------------------------------------------

    // CONFIG
    Route::get('config', 'ConfigController@index');
    Route::get('config/{key}', 'ConfigController@show');

    // MISC
    Route::get('countries', 'CountriesController@index');
    Route::put('devices', 'DevicesController@register');
    Route::post('feedback', 'FeedbackController@send');

    Route::get('skills/suggest/{term?}', 'SkillsController@suggest');
    Route::get('elastic/repair', 'SearchEngineController@repair');
    Route::get('cloud/empty', 'CloudController@emptyAllContainers');

    // SERVICE
    Route::get('services/test', 'ServicesController@test');
	Route::get('services/message', 'ServicesController@message');

});


// -------------------------------------------------------------------------------
// ADMINISTRATION
$adminRoutes = function() {

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

};


// -------------------------------------------------------------------------------
Route::group(['domain' => 'desk.nudj.co'], $adminRoutes);
Route::group(['prefix' => '/'], $adminRoutes);


// -------------------------------------------------------------------------------
// Listen for some stuff
if (env('APP_ENV') != 'production' && Input::get('debug') == 'sql') {
    Event::listen('illuminate.query', function ($query) {
        echo($query . "\r\n");
    });
}
