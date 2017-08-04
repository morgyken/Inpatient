<?php

Route::group(['middleware' => 'web', 'prefix' => 'inpatient', 'as' => 'inpatient.', 'namespace' => 'Ignite\Inpatient\Http\Controllers'], function() {
    Route::get('/admit', 'InpatientController@index');
});
