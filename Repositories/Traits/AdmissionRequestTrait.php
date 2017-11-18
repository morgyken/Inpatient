<?php

namespace Ignite\Inpatient\Repositories\Traits;

use Ignite\Inpatient\Repositories\ChargeRepository;

use Carbon\Carbon;

trait AdmissionRequestTrait
{
    /*
    * Notifies the rest of the trait if the admission request has been authorized
    */
    protected $isAuthorized;

    protected $chargeRepository;

    public function __construct(ChargeRepository $chargeRepository)
    {
        $this->chargeRepository = $chargeRepository;
    }

    public function transform($request)
    {
        return [
            'id' => $request->id,

            'reason' => $request->reason,

            'authorization' => $this->authorization($request),

            'can_admit' => $this->canAdmit($request),

            'created_at' => Carbon::parse($request->created_at)->toFormattedDateString(),

            'patient' => $this->patient($request->patient),

            'type' => $this->admissionType($request->admissionType)
        ];
    }

    /*
    * Return the authorization status and the amount authorized
    * Allow admission if authorized, even if amount is zero
    */
    public function authorization($request)
    {
        return [
            'status' => (bool)$request->authorized_by,
            'amount' => $request->authorized
        ];
    }

    /*
    * Checks if one can admit a patient given all the variables available
    */
    public function canAdmit($request)
    {
        $patient = $request->patient;

        $schemes = $patient->schemes;

        $deposit = $request->admissionType->deposit;

        $accountBalance = $request->patient->account ? $request->patient->account->balance : 0;

        $authorized = (bool) $request->authorized_by;

        $authorizedAmount = $request->authorized;

        if($authorized and $accountBalance >= $authorizedAmount)
        {
            return true;
        }

        if($accountBalance >= $deposit)
        {
            return true;
        }

        if(count($schemes) > 0)
        {
            if($request->insuranceMaximumAmount->count() > 0)
            {
                return true;
            }
        }

        return false;
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
    public function patientSchemes($companies)
    {
        return $companies ? $companies->pluck('schemes') : [];
    }

    /*
    * Tranforms the amdission type within an admission request into a more json encodedable array
    */
    public function admissionType($admissionType)
    {
        $name = $admissionType->name;

        $deposit = $admissionType->deposit;

        $description = $admissionType->description;

        return compact('name', 'deposit', 'description');
    }

}

