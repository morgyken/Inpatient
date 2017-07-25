<?php

use Ignite\Core\Contracts\Authentication;
use Illuminate\Routing\Router;

/**
 * Collabmed Inpatient Routes
 *  Odhiambo Dormnic <dodhiambo@collabmed.net>
 *
*/
Route::group(['prefix'=>'inpatient', 'as'=>'inpatient'],function(Router $router){

    $router->match(['get', 'post'], 'admit', ['uses' => 'InpatientController@index', 'as' => 'admit']);
});


