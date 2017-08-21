<?php

namespace Ignite\Inpatient\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Response;
use Validator;
use Session;
use Lava;

use Ignite\Inpatient\Entities\Admission;
use Ignite\Inpatient\Entities\Deposit;
use Ignite\Inpatient\Entities\RequestDischarge;
use Ignite\Inpatient\Entities\DischargeNote;
use Ignite\Inpatient\Entities\PatientAccount;
use Ignite\Evaluation\Entities\FinancePatientAccounts;
use Ignite\Inpatient\Entities\NursingCharge;
use Ignite\Inpatient\Entities\RequestAdmission;
use Ignite\Inpatient\Entities\Visit;
use Ignite\Inpatient\Entities\Ward;
use Ignite\Inpatient\Entities\WardAssigned;
use Ignite\Inpatient\Entities\Bed;
use Ignite\Inpatient\Entities\BedPosition;
use Ignite\Evaluation\Entities\Vitals;
use Ignite\Evaluation\Entities\DoctorNotes;
use Ignite\Reception\Entities\Patients;
use Ignite\Users\Entities\Roles;
use Ignite\Users\Entities\UserRoles;
use Ignite\Users\Entities\User;

use Ignite\Evaluation\Entities\Prescriptions;

class InpatientApiController extends Controller
{
	private $admission;
	private $request_admission;
    private $roles;
    private $user_roles;
    private $user;
    private $patients;
    private $visit;

	public function __construct(Admission $admission, Patients $patients, RequestAdmission $request_admission, Roles $roles, User $user, UserRoles $user_roles, Visit $visit){

		$this->admission = $admission;
		$this->request_admission = $request_admission; 
		$this->roles = $roles;
        $this->user_roles = $user_roles;
        $this->user = $user;
        $this->patients = $patients;
        $this->visit = $visit;
	}

	public function getAllPatients(){
		$patients = $this->patients->latest()->get()->map(function ($item){
			return $items['results'] = 
			[
				"id"			=> $item->id,
				"id_number" 	=> $item->id_no,
				"profile"		=> $item->image,
				"fullname" 		=> $item->fullName,
				"registered" 	=> $item->registered
			];
		})->toJson();

		return $patients;
	}

	public function getPatientsAwaitingAdmission(){
		$patients = $this->request_admission->latest()->get()->map(function ($item){
			return $items['results'] = 
			[
				"id"			=> $item->id,
				"id_number" 	=> $item->patient->id_no,
				"profile"		=> $item->patient->image,
				"fullname" 		=> $item->patient->fullName,
				"requested" 	=> \Carbon\Carbon::parse($item->created_at)->format('m/d/y')
			];
		})->toJson();

		return $patients;
	}

	public function getPatientsAdmitted(){
		$patients = $this->admission->latest()->get()->map(function ($item){
			return $items['results'] = 
			[
				"id" 			=> $item->id,
				"fullname" 		=> $item->patient->fullName,
				"doctor"		=> (is_null($item->doctor_id)) ? $item->external_doctor : $item->doctor->profile->first_name." ".$item->doctor->profile->last_name,
				"ward"			=> $item->ward->name,
				"bed"			=> $item->bed->number,
				"cost"			=> $item->cost,
				"admitted" 	=> \Carbon\Carbon::parse($item->created_at)->format('m/d/y')
			];
		})->toJson();

		return $patients;
	}

}