<?php

use Ignite\Core\Contracts\Authentication;
use Illuminate\Routing\Router;
/**
 * Collabmed Inpatient Routes
 *
*/
Route::group(['prefix' => 'inpatient', 'as' => 'inpatient'], function(Router $router){
    $router->get('/admit', ['uses' => 'InpatientController@admit' , 'as' =>'admit']);
});
