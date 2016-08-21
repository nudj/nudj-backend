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

    // ---------------------------
    // Reimplementation 

    Route::get('register/{jobId}', 'Web\WebController@login2');
    Route::post('validate', 'Web\WebController@validate2'); # The page after submitting your phone number and where you need to put the pin 
    Route::post('verify', 'Web\ActionsController@verify'); # This is a AJAX call to validate the 4 letter digit validation code. 
    Route::post('apply', 'Web\ActionsController@apply');
    Route::post('refer', 'Web\ActionsController@nudge');
    Route::get('download', 'Web\WebController@download');

    // ---------------------------
    // Reimplementation 

    Route::get('jobpreview/{jobId}',    'Web\WebController@jobview');
    Route::get('job/{jobId}',           'Web\WebController@jobview');

    Route::get('applying/{jobId}',      'Web\WebController@applying');    
    Route::get('appdownloads',          'Web\WebController@appdownloads'); 
    Route::get('nudj-a-friend/{jobId}', 'Web\WebController@nudjAFriend'); 

    Route::post('applicationdetails',   'Web\ActionsController@applicationDetails'); 

});

