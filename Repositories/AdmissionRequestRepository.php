<?php

namespace Ignite\Inpatient\Repositories;

use Ignite\Inpatient\Repositories\Traits\AdmissionRequestTrait;

use Ignite\Inpatient\Entities\AdmissionRequest;

use Ignite\Evaluation\Entities\Visit;

use Carbon\Carbon;

class AdmissionRequestRepository
{
    use AdmissionRequestTrait;

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

        $admissionRequest = AdmissionRequest::create($fields);

        $visit = Visit::find($fields['visit_id']);

        $visit->admission_request_id = $admissionRequest->id;

        $visit->save();

        return $admissionRequest;
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

        return $admissionRequests->map(function($admissionRequest){

            return $this->transform($admissionRequest);

        });
    }

    /*
    * Returns true if a patient has been admitted and false otherwise
    */
    public function admitted($patientAdmission)
    {
        return $patientAdmission and is_null($patientAdmission->deleted_at);
    }

    /*
    * Delete the admission request by setting the deleted at field to the current date
    */
    public function delete($id)
    {
        $admissionRequest = $this->find($id);

        $admissionRequest->deleted_at = Carbon::now();

        $admissionRequest->save();
    }

    public function jsonAdmissionRequests($admissionRequests)
    {
        return $admissionRequests->map(function($admissionRequest){

            $type = $admissionRequest['type']['name']." (". $admissionRequest['type']['deposit'].")";

            return [
                $admissionRequest['patient']['name'],
                $admissionRequest['patient']['account']['balance'],
                $type,
                $admissionRequest['authorization']['amount'],
                $admissionRequest['created_at'],

                $this->actions($admissionRequest)
            ];

        });
    }
}