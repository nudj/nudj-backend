<?php

// -------------------------------------------------------------------------------
// Define patterns for expected parameters
$router->pattern('id', '([0-9]+)');
$router->pattern('userid', '([0-9]+)|(me)');
$router->pattern('filter', '([a-z]+)');

// -------------------------------------------------------------------------------
// Default view
Route::get('/', 'Web\HomeController@index');

// -------------------------------------------------------------------------------
// Web view
Route::group(['prefix' => '/'], function () {

	// Relevant Information: 2c4e861f-be97-49a2-ad53-2d9c2f6a7f74

    Route::get('register/{jobId}', 'Web\WebController@login2');

    Route::post('validate', 'Web\WebController@validate2'); # The page after submitting your phone number and where you need to put the pin 

    Route::post('verify', 'Web\ActionsController@verify'); # This is a AJAX call to validate the 4 letter digit validation code. 

    Route::get('job/{jobId}/{hash?}', 'Web\WebController@job');

    Route::post('apply', 'Web\ActionsController@apply');
    Route::post('refer', 'Web\ActionsController@nudge');
    Route::get('countries', 'Web\ActionsController@countries');
    Route::get('download', 'Web\WebController@download');

    // ---------------------------
    // Reimplementation 

    Route::get('jobpreview/{jobId}', 'Web\WebController@jobpreview2');

});

// -------------------------------------------------------------------------------
// HTML sources accessed from the app
Route::group(['prefix' => 'html'], function () {
    Route::get('terms', 'HtmlController@terms');
    Route::get('privacy', 'HtmlController@privacy');
    Route::get('cookies', 'HtmlController@cookies');
});

// -------------------------------------------------------------------------------
// Listen for some stuff
if (env('APP_ENV') != 'production' && Input::get('debug') == 'sql') {
    Event::listen('illuminate.query', function ($query) {
        echo($query . "\r\n");
    });
}
