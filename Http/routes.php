<?php

Route::group(['middleware' => 'web', 'prefix' => 'inpatient', 'namespace' => 'Ignite\Inpatient\Http\Controllers'], function()
{
    Route::get('/', 'InpatientController@index');
});
