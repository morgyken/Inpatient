<?php

Route::group(['middleware' => 'web', 'prefix' => 'inpatient', 'namespace' => 'Ignite\Inpatient\Http\Controllers'], function()
{
    Route::get('/details', 'AdmissionsController@index')->name('admissions.index');
});
