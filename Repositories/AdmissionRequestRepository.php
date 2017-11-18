<?php

namespace Ignite\Inpatient\Repositories;

use Ignite\Inpatient\Entities\AdmissionRequest;

use Carbon\Carbon;

class AdmissionRequestRepository
{
    protected $admissionRequest;

    /*
    * Gets an admission request by id
    */
    public function find($id)
    {
        return AdmissionRequest::find($id);
    }

    /*
    * Create an admission request for view by the cashier
    * Sets the default admitted type to false
    */
    public function create($fields)
    {
        $fields['admitted'] = false;

        $fields['deleted_at'] = null;

        return AdmissionRequest::create($fields);
    }

    /*
    * Update the field
    */
    public function update($id, $fields)
    {
        return AdmissionRequest::where('id', $id)->update($fields);
    }

    /*
    * Return the admission requests that have been made by the doctors
    */
    public function getAdmissionRequests()
    {
        $admissionRequests = AdmissionRequest::orderBy('created_at', 'ASC')->get();

        return $admissionRequests->map(function($request){

            return [
                'id' => $request->id,

                'reason' => $request->reason,

                'authorized' => $request->authorized,

                'due' => $this->due($request),

                'can_admit' => $this->admit($request),

                'created_at' => Carbon::parse($request->created_at)->toFormattedDateString(),

                'patient' => $this->patient($request->patient),

                'type' => $this->admissionType($request->admissionType)
            ];

        });
    }

    /*
    * Tranforms the patient within an admission request into a more json encodedable array
    */
    public function patient($patient)
    {
        return [
            'id' => $patient->id,
            'name' => $patient->fullName,
            'visit' => $patient->visit_id,
            'account' => $this->patientAccount($patient->account),
            'schemes' => $this->patientSchemes($patient->schemes),
        ];
    }

    /*
    * Returns true if a patient has been admitted and false otherwise
    */
    public function admitted($patientAdmission)
    {
        return $patientAdmission and is_null($patientAdmission->deleted_at);
    }

    /*
    * Transform the patient account
    */
    public function patientAccount($account)
    {
        $accounts['balance'] = $account ? $account->balance : 0;

        return $accounts;
    }

    /*
    * Transform the details of the patient schemes
    */
    public function patientSchemes($schemes)
    {
        return $schemes ? $schemes : [];
    }

    /*
    * Tranforms the amdission type within an admission request into a more json encodedable array
    */
    public function admissionType($type)
    {
        return [
            'name' => $type->name,
            'deposit' => $type->deposit,
            'description' => $type->description
        ];
    }

    /*
    * Add the amount due before the patient can receive any form of treatment
    */
    public function due($request)
    {
        if($request->authorized)
        {
            return $request->authorized;
        }

        $deposit = $request->admissionType->deposit;

        $balance = $request->patient->account ? $request->patient->account->balance : 0;

        return ($deposit - $balance) < 0 ? 0 : ($deposit - $balance);
    }

    /*
    * Determine if a request is good enough for admittance
    */
    public function admit($request)
    {
        $balance = $request->patient->account ? $request->patient->account->balance : 0;

        if(count($request->patient->schemes) > 0)
        {
            return true;
        }
        else
        {
            return $request->authorized ? $balance >= $request->authorized : $this->due($request) === 0;
        }

        return false;
    }

    /*
    * Delete the admission request by setting the deleted at field to the current date
    */
    public function delete($id)
    {
        $admissionRequest = $this->find($id);

        $admissionRequest->deleted_at = Carbon::now();

        $admissionRequets->save();
    }

    

}