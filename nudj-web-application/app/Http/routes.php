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

    Route::get('jobpreview/{jobId}',    'Web\WebController@jobview');
    Route::get('job/{jobId}',           'Web\WebController@jobview');

    Route::get('applying/{jobId}',      'Web\WebController@applying');    
    Route::get('appdownloads',          'Web\WebController@appdownloads'); 
    Route::get('nudj-a-friend/{jobId}', 'Web\WebController@nudjAFriend'); 

    Route::post('applicationdetails',   'Web\ActionsController@applicationDetails'); 

});

