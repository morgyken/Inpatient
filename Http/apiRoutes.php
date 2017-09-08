<?php

Route::group(['prefix' => 'v1'], function () {

    Route::group(['prefix' => 'patients'], function () {
        // Get all Patients
        // Route::get('/', 'InpatientApiController@getAllPatients');

        // Get all Patients
        Route::get('/{id}', 'InpatientApiController@getPatientDetails');

        // Get all Patients Awaiting Admission
        // Route::get('/awaiting', 'InpatientApiController@getPatientsAwaitingAdmission');

        // Get all Patients Awaiting Admission
        Route::get('/admitted', 'InpatientApiController@getPatientsAdmitted');
    });

    Route::group(['prefix' => 'vitals'], function () {
        // Get Patient Vitals
        Route::get('/admission/{admission_id}', 'InpatientApiController@getPatientVitals');

        // Save vitals
        Route::post('', 'InpatientApiController@saveUpdateVitals');

        // Update vitals
        Route::post('/update', 'InpatientApiController@saveUpdateVitals');

        // Delete vitals
        // Route::post('/delete', 'InpatientApiController@deleteVitals');
    });

    Route::group(['prefix' => 'investigations'], function () {
        // Get all investigations
        Route::get('/visit/{visit_id}', 'InpatientApiController@getAllInvestigations');

        // Get list of procedures
        Route::get('/procedures', 'InpatientApiController@getAllProcedures');

        // add investigations
        Route::post('', 'InpatientApiController@addInvestigations');

        // Delete investigation
        Route::post('/delete', 'InpatientApiController@deleteInvestigations');
    });

    Route::group(['prefix' => 'drugs'], function () {
        // Get the drugs .... Pablo Escobar style hehe
        Route::get('/{term}', 'InpatientApiController@getDrug');
    });

    Route::group(['prefix' => 'prescriptions'], function () {

        // Get all prescriptions
        Route::get('/admission/{admission_id}/type/{type}', 'InpatientApiController@getAllPrescriptions');

        // Add Prescription
        Route::post('', 'InpatientApiController@addPrescription');

        // Update Prescription
        Route::post('/cancel', 'InpatientApiController@deletePrescription');

        // Update Prescription
        Route::post('/update', 'InpatientApiController@updatePrescription');

        Route::post('/delete', 'InpatientApiController@deletePrescription');

        // Administer Prescription
        Route::post('/administer', 'InpatientApiController@administerPrescription');

        // Update Administration Log
        Route::post('/administration/update', 'InpatientApiController@updateAdministeredPrescriptionLog');

        //Delete administration log
        Route::post('/administration/delete', 'InpatientApiController@deleteAdministeredPrescriptionLog');
    });

    // Route::group(['prefix' => 'diagnosis'], function() {
    //     // Get all diagnosis
    //     Route::get('/patient/{id}/visit/{visit_id}', 'InpatientApiController@getAllDiagnosis');

    // });

    Route::group(['prefix' => 'procedures'], function () {

        Route::get('/all', 'InpatientApiController@getAllProcedures');

        Route::get('/admission/{admission_id}/visit/{visit_id}', 'InpatientApiController@getProcedures');

        // Get all Performed Procedures
        Route::get('/performed/admission/{admission_id}', 'InpatientApiController@getAllPerformedProcedures');

        // Get all Queued Procedures
        Route::get('/queued/admission/{admission_id}', 'InpatientApiController@getAllQueuedProcedures');
    });

    Route::group(['prefix' => 'notes'], function () {

        // Get notes
        Route::get('/admission/{admission_id}/type/{type}', 'InpatientApiController@getNotes');

        // Save Doctor's and Nurse's notes
        Route::post('', 'InpatientApiController@addNote');

        // Delete Doctor's and Nurse's notes
        Route::post('/delete', 'InpatientApiController@deleteNote');

        // Update Doctor's and Nurse's notes
        Route::post('/{id}/update', 'InpatientApiController@updateNote');

    });

    Route::group(['prefix' => 'headinjuries'], function () {
        // Get Head Injury Data
        Route::get('/admission/{admission_id}', 'InpatientApiController@getHeadInjuries');

        // Save head Injury data
        Route::post('', 'InpatientApiController@addHeadInjury');

        // Update Head Injury Data
        Route::post('/{id}/update', 'InpatientApiController@updateHeadInjury');

        // Delete Head Injury Data
        Route::post('/{id}/delete', 'InpatientApiController@deleteHeadInjury');
    });

    Route::group(['prefix' => 'fluidbalances'], function () {
        // Get Fluid Balance Data
        Route::get('/admission/{admission_id}', 'InpatientApiController@getFluidBalances');

        // Save head Injury data
        Route::post('', 'InpatientApiController@addFluidBalances');
    });

    Route::group(['prefix' => 'transfusions'], function () {
        // Get Blood Transfusion Data
        // Get Head Injury Data
        Route::get('/admission/{admission_id}', 'InpatientApiController@getBloodTransfusions');

        // Save head Injury data
        Route::post('', 'InpatientApiController@addBloodTransfusions');
    });

    Route::group(['prefix' => 'plans'], function () {
        Route::get('/admission/{admission_id}', 'InpatientApiController@getNursingCarePlans');

        Route::post('', 'InpatientApiController@addNursingCarePlans');

        Route::post('/update', 'InpatientApiController@updateNursingCarePlans');

        Route::post('/delete', 'InpatientApiController@deleteNursingCarePlans');
    });


    // Get patient Temperature for plotting


    // Get patient blood pressure for plotting

    Route::post('saver/blood_pressure', ['as' => 'mark_bp', 'uses' => 'InpatientApiController@postBp']);
});