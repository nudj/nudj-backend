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
    Route::get('/jobs/create', 'Desk\JobsController@createpage');

    // STATIC CONTENTS
    Route::get('/staticcontents', 'Desk\StaticContentsController@index');
    Route::get('/staticcontentselement/{reference}', 'Desk\StaticContentsController@showelement');
    Route::post('/staticcontentselement/{reference}', 'Desk\StaticContentsController@updateelement');

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
// API V1 routes

Route::group(['prefix' => 'deskapi'], function () {

    // JOBS
    Route::post('ajax_update_job/{id}',           'Desk\JobsController@ajax_update_job');
    Route::post('ajax_create_job',                'Desk\JobsController@ajax_create_job');
    Route::post('ajax_set_job_owner/{id1}/{id2}', 'Desk\JobsController@ajax_set_job_owner');

    // SKILLS
    Route::get('job_skills_DataTypeB7B00162/{id}',     'Desk\JobsController@ajax_get_job_skills_DataTypeB7B00162');
    Route::delete('remove_skill_from_job/{id1}/{id2}', 'Desk\JobsController@ajax_remove_skill_from_job');
    Route::post('add_skill_to_job',                    'Desk\JobsController@ajax_add_skill_to_job');

    // USERS
    Route::post('ajax_update_user/{id}',   'Desk\UsersController@ajax_update_user');
    Route::post('admin_block_user/{id}',   'Desk\UsersController@admin_block_user');
    Route::post('admin_unblock_user/{id}', 'Desk\UsersController@admin_unblock_user');

    Route::post('admin_enable_special_access/{id}',  'Desk\UsersController@admin_enable_special_access');
    Route::post('admin_disable_special_access/{id}', 'Desk\UsersController@admin_disable_special_access');

});

// -------------------------------------------------------------------------------
// Listen for some stuff
if (env('APP_ENV') != 'production' && Input::get('debug') == 'sql') {
    Event::listen('illuminate.query', function ($query) {
        echo($query . "\r\n");
    });
}
