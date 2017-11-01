<?php

Route::group(['as' => 'inpatient.'], function() {

    /*
    |--------------------------------------------------------------------------
    | TESTING
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | PRINTING
    |--------------------------------------------------------------------------
    */

    Route::get('/chargesheet/{visit_id}', 'InpatientController@buildChargeSheet');
    Route::get('/summary/{visit_id}','InpatientController@buildDischargeSummary');

	/*
    |--------------------------------------------------------------------------
    | Patient Admissions
    |--------------------------------------------------------------------------
    */

    Route::get('/admit', 'InpatientController@index');
    Route::get('/awaiting', 'InpatientController@awaiting');
    Route::post('/requestAdmission', 'InpatientController@requestAdmission');
    Route::get('/admit/{id}', 'InpatientController@admitWalkInPatient');
    Route::get('/admit/{id}/visit/{visit_id}', 'InpatientController@admitPatientForm');
    Route::post('/admit_patient', 'InpatientController@admit');
    Route::get('/admit_check', 'InpatientController@admit_check');
    Route::get('/admissions', 'InpatientController@admissionList');
    Route::get('/admissions/logs', 'InpatientController@admissionLogs');
    Route::get('/admission/cancel/{id}', 'InpatientController@cancel');
    //manage patient
    Route::get('/manage/{id}/visit/{visit_id}', 'InpatientController@managePatient');
    //admit patient awaiting
    Route::get('/awaitingAdmission', 'InpatientController@admitAwaiting');
    Route::get('/manage/{id}/visit/{visit_id}/move', 'InpatientController@movePatient');

    /*
    |--------------------------------------------------------------------------
    | Ward Management
    |--------------------------------------------------------------------------
    */
    
    Route::group(['prefix' => 'ward'], function(){
        Route::get('/{id}/recurrent_charges','WardController@getWardCharges')->name('inpatient.wards.charges');
        Route::get('/all','WardController@getAll');
        Route::get('/list','WardController@index')->name('inpatient.wards.index');
        Route::post('/add',['uses'=>'WardController@store'])->name('inpatient.wards.store');
        Route::get('/editWard/{ward_id}','WardController@getRecordWard')->name('inpatient.wards.edit');;
        Route::post('/{id}/update', 'WardController@update')->name('inpatient.wards.update');;
        Route::get('/{id}/delete',['uses'=>'WardController@destroy'])->name('inpatient.wards.delete');
    });

    /*
    |--------------------------------------------------------------------------
    | Bed Management
    |--------------------------------------------------------------------------
    */

    Route::group(['prefix' => 'beds'], function(){
        Route::post('/change_bed','BedsController@change_bed');
        Route::get('/bedList',['uses'=>'BedsController@index']);
        Route::get('/bedTypes',['uses'=>'BedsController@listBedTypes']);
        Route::post('/type/add',['uses'=>'BedsController@addBedType']);
        Route::get('/type/{id}/delete',['uses'=>'BedsController@deleteBedType']);
        Route::get('/position',['uses'=>'BedsController@bedPosition']);
        Route::post('/position',['uses'=>'BedsController@postBedPosition']);
        Route::get('/position/{ward_id}',['uses'=>'BedsController@deleteBedPosition']);
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
    | Accounts Management
    |--------------------------------------------------------------------------
    */

    Route::group(['prefix' => 'accounts'], function(){
        Route::post('/addReccurentCharge',['uses'=>'AccountsController@addReccurentCharge']);
        Route::get('/deposit',['uses'=> 'AccountsController@deposit']);
        Route::get('/deposits/all',['uses'=> 'AccountsController@getAllDeposits']); 
        Route::post('/deposits/edit',['uses'=>'AccountsController@editDeposit']);
        Route::post('/addDepositType',['uses'=> 'AccountsController@addDepositType']);
        Route::get('/delete_deposit/{deposit_id}',['uses'=>'AccountsController@delete_deposit']);
        Route::get('/edit_deposit/{deposit_id}',['uses'=>'AccountsController@edit_deposit']);
       
        Route::post('/topUpAccount',['uses'=>'AccountsController@topUpAccount']);
        Route::get('/topUp',['uses'=>'AccountsController@topUp']);
        Route::post('/topUpAmount',['uses'=>'AccountsController@topUpAmount']);
        Route::get('/withdraw',['uses'=>'AccountsController@withdraw']);
        Route::post('/WithdrawAmount',['uses'=>'AccountsController@WithdrawAmount']);   
        Route::get('/account_deposit/{patient}',['uses'=>'InpatientController@account_deposit_amount']);
        Route::get('/account_withdraw/{patient}',['uses'=>'InpatientController@account_withdraw_amount']);
        Route::post('/PostWithdrawAccount',['uses'=>'InpatientController@PostWithdrawAccount']);
    });


     /*
    |--------------------------------------------------------------------------
    | Nursing Services Management
    |--------------------------------------------------------------------------
    */

    Route::group(['prefix' => 'nursing'], function(){
        /*nursing & admission charges*/
        Route::get('/services',['uses'=>'AccountsController@getNursingServices']); 
        Route::get('/delete_service/{service}',['uses'=>'AccountsController@delete_service']);
    });

 	/*
    |--------------------------------------------------------------------------
    | Requests Management
    |--------------------------------------------------------------------------
    */   
    
    Route::get('/cancel_checkin',['uses'=>'InpatientController@cancel_checkin']);

    Route::get('/getAvailableBedPosition/{ward}',['uses'=>'InpatientController@getAvailableBedPosition']);
   
    //cancel request admissin
    Route::get('/cancel_request/{visit}',['uses'=>'InpatientController@cancel_request']);
    //request discharge
    Route::get('/manage/{id}/requestDischarge/{visit_id}',['uses'=>'InpatientController@request_discharge']);
    Route::get('/request_discharge',['uses'=>'InpatientController@requested_discharge']);
    //discharge the patient..
    Route::get('/discharge/{visit_id}',['uses'=>'InpatientController@confirm_discharge']);
    //cancel discharge
    Route::get('/Cancel_discharge/{visit}',['uses'=>'InpatientController@Cancel_discharge']);
    /*discharge the patient*/
    Route::post('/postDischargePatient',['uses'=>'InpatientController@postDischargePatient']);
    
   
    //print deposit slip
    Route::get('/print',['uses'=>'InpatientController@print']);
    //post discharge note
    Route::post('/postDischargeNote',['uses'=>'InpatientController@postDischargeNote']);


    //Admission Types
    Route::get('/admission-types', ['uses' => 'AdmissionTypeController@index']);
    Route::post('/admission-types', ['uses' => 'AdmissionTypeController@store']);
    Route::get('/admission-types/edit/{id}', ['uses' => 'AdmissionTypeController@edit']);
    Route::post('/admission-types/{id}/update', ['uses' => 'AdmissionTypeController@update']);

    //Admission Types API
    Route::get('/admission-types/listing', ['uses' => 'AdmissionTypeController@listing']);
// ********************************************* API ****************************************************************** \\

    
});
