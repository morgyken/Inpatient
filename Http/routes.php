<?php

Route::group(['middleware' => 'web', 'prefix' => 'inpatient', 'as' => 'inpatient.', 'namespace' => 'Ignite\Inpatient\Http\Controllers'], function() {

	/*
    |--------------------------------------------------------------------------
    | Patient Admissions
    |--------------------------------------------------------------------------
    */

    Route::get('/admit', 'InpatientController@index');
    Route::get('/awaiting', 'InpatientController@awaiting');
    Route::post('/requestAdmission', 'InpatientController@requestAdmission');
    Route::get('/admit/{id}/{visit_id}', 'InpatientController@admitPatientForm');
    Route::post('/admit_patient', 'InpatientController@admit');
    Route::get('/admit_check', 'InpatientController@admit_check');
    Route::get('/admissions', 'InpatientController@admissionList');
    Route::get('/admission/cancel/{id}', 'InpatientController@cancel');
    //manage patient
    Route::get('/manage/{patient_id}', 'InpatientController@managePatient');
    Route::post('/manage/{patient_id}', 'InpatientController@recordVitals');
    //admit patient awaiting
    Route::get('/awaitingAdmission', 'InpatientController@admitAwaiting');
    // Route::post('/admit_patientPostForm', 'InpatientController@admit_patientPostForm');

   /*
    |--------------------------------------------------------------------------
    | Ward Management
    |--------------------------------------------------------------------------
    */
    Route::group(['prefix' => 'ward'], function(){
        Route::get('/list','WardController@listWards')->name('inpatient.wards.index');
        Route::post('/add',['uses'=>'WardController@store'])->name('inpatient.wards.store');
        Route::get('/editWard/{ward_id}',['uses'=>'WardController@getRecordWard']);
        Route::post('/update_ward',['uses'=>'WardController@update']);
        Route::get('/delete/{ward_id}',['uses'=>'WardController@deleteThisWard']);
        Route::post('/delete',['uses'=>'WardController@destroy'])->name('inpatient.wards.delete');
    });

    /*
    |--------------------------------------------------------------------------
    | Bed Management
    |--------------------------------------------------------------------------
    */

    Route::group(['prefix' => 'beds'], function(){
        Route::get('/bedList',['uses'=>'BedsController@index']);
        Route::get('/bedPosition',['uses'=>'BedsController@bedPosition']);
        Route::post('/bedPosition',['uses'=>'BedsController@postbedPosition']);
        Route::get('/bedPosition/{ward_id}',['uses'=>'BedsController@deletebedPosition']);
        Route::post('/postaddbed',['uses'=>'BedsController@postaddBed']);
        Route::get('/editBed/{id}',['uses'=>'BedsController@editBed']);
        Route::post('/bedList',['uses'=>'BedsController@update']);
        
        Route::get('/addBed',['uses'=>'BedsController@addWard']);
        Route::post('/addBedFormPost',['uses'=>'BedsController@addBedFormPost']);
        Route::get('/availableBeds/{ward_id}',['uses'=>'BedsController@availableBeds']);
        Route::get('/delete_bed/{id}',['uses'=>'BedsController@postdelete_bed']);
        Route::post('/delete_bed',['uses'=>'BedsController@delete_bed']);
    });

 	/*
    |--------------------------------------------------------------------------
    | Requests Management
    |--------------------------------------------------------------------------
    */

	// ancel request admission
    Route::get('/cancel/{id}',['uses'=>'InpatientController@cancel']);
    /*nursing charges*/
    Route::get('/Nursing_services',['uses'=>'InpatientController@Nursing_services']);
    //add recurrent charge
    Route::get('/add_recurrent_charge',['uses'=>'InpatientController@add_recurrent_charge']);
    //save new reccurent charge
    Route::post('/AddReccurentCharge',['uses'=>'InpatientController@AddReccurentCharge']);

//     //deposit setting
    Route::get('/deposit',['uses'=>'InpatientController@deposit']);
    Route::post('/addDepositType',['uses'=>'InpatientController@addDepositType']);
    //delete deposit type
    Route::get('/delete_deposit/{deposit_id}',['uses'=>'InpatientController@delete_deposit']);
    Route::get('/admit_check',['uses'=>'InpatientController@admit_check']);
    Route::get('/topUp',['uses'=>'InpatientController@topUp']);
    Route::post('/topUpAmount',['uses'=>'InpatientController@topUpAmount']);
    Route::get('/withdraw',['uses'=>'InpatientController@withdraw']);
    Route::post('/WithdrawAmount',['uses'=>'InpatientController@WithdrawAmount']);

    Route::get('/cancel_checkin',['uses'=>'InpatientController@cancel_checkin']);
    //edit a deposit
    Route::get('/edit_deposit/{deposit_id}',['uses'=>'InpatientController@edit_deposit']);
    Route::post('/deposit_adit',['uses'=>'InpatientController@deposit_adit']);
    Route::post('/topUpAccount',['uses'=>'InpatientController@topUpAccount']);


    Route::get('/getAvailableBedPosition/{ward}',['uses'=>'InpatientController@getAvailableBedPosition']);
    Route::post('/change_bed',['uses'=>'InpatientController@change_bed']);
    //cancel request admissin
    Route::get('/cancel_request/{visit}',['uses'=>'InpatientController@cancel_request']);
    //request discharge
    Route::get('/request_discharge/{visit_id}',['uses'=>'InpatientController@request_discharge']);
    Route::get('/request_discharge',['uses'=>'InpatientController@requested_discharge']);
    //discharge the patient..
    Route::get('/discharge/{visit}',['uses'=>'InpatientController@confirm_discharge']);
    //cancel discharge
    Route::get('/Cancel_discharge/{visit}',['uses'=>'InpatientController@Cancel_discharge']);
    /*discharge the patient*/
    Route::post('/postDischargePatient',['uses'=>'InpatientController@postDischargePatient']);
    //delete service
    Route::get('/delete_service/{service}',['uses'=>'InpatientController@delete_service']);

///patient account operations
    //deposit amount..
    Route::get('/account_deposit/{patient}',['uses'=>'InpatientController@account_deposit_amount']);
    Route::post('/topUpAccount',['uses'=>'InpatientController@topUpAccountPost']);
    //withdraw an amount
    Route::get('/account_withdraw/{patient}',['uses'=>'InpatientController@account_withdraw_amount']);
    Route::post('/PostWithdrawAccount',['uses'=>'InpatientController@PostWithdrawAccount']);
//print deposit slip
    Route::get('/print',['uses'=>'InpatientController@print']);
    //post discharge note
    Route::post('/postDischargeNote',['uses'=>'InpatientController@postDischargeNote']);
});
