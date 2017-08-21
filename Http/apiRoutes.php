<?php

Route::group(['middleware' => 'web', 'prefix' => 'inpatient/api/v1', 'as' => 'inpatient.api.', 'namespace' => 'Ignite\Inpatient\Http\Controllers'], function() {

	// // Get all Patients
	// Route::get('/patients', 'InpatientApiController@getAllPatients');

	// // Get all Patients Awaiting Admission
	// Route::get('/patients/awaiting', 'InpatientApiController@getPatientsAwaitingAdmission');

	// // Get all Patients Awaiting Admission
	// Route::get('/patients/admitted', 'InpatientApiController@getPatientsAdmitted');

	// Get patient Temperature for plotting
	

	// Get patient blood pressure for plotting
	

	// Get patient weight for plotting
	

	// Get patient height for plotting
	

});