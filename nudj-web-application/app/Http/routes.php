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

    Route::get('jobpreview/{jobId}',    'WebController@jobview');
    Route::get('job/{jobId}',           'WebController@jobview');

    Route::get('apply/{jobId}',                   'WebController@apply');    
    Route::get('appdownloads/{applicationuuid}',  'WebController@appdownloads'); 
    Route::get('nudj-a-friend/{jobId}',           'WebController@nudjAFriend');

    Route::post('applicationdetails', 'ActionsController@applicationDetails'); 
    Route::post('send-link-to-candidate-1a345374/{applicationuuid}', 'ActionsController@sendLinkToCandidate');

});

