<?php

// -------------------------------------------------------------------------------
// Define patterns for expected parameters
$router->pattern('id', '([0-9]+)');
$router->pattern('userid', '([0-9]+)|(me)');
$router->pattern('filter', '([a-z]+)');

// -------------------------------------------------------------------------------
// Default view
Route::get('/', 'HomeController@index');

// -------------------------------------------------------------------------------
// Web view
Route::group(['prefix' => '/'], function () {

    // ---------------------------
    // Reimplementation 

    Route::get('jobpreview/{jobId}',    'WebController@jobview');
    Route::get('job/{jobId}',           'WebController@jobview');

    Route::get('apply/{jobId}',         'WebController@apply');    
    Route::get('appdownloads',          'WebController@appdownloads'); 
    Route::get('nudj-a-friend/{jobId}', 'WebController@nudjAFriend'); 

    Route::post('applicationdetails',   'ActionsController@applicationDetails'); 

});

