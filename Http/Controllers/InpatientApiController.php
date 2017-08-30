<?php

namespace Ignite\Inpatient\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Response;
use Validator;
use Session;
use Lava;
use DB;

use Ignite\Inpatient\Entities\Admission;
use Ignite\Inpatient\Entities\Deposit;
use Ignite\Inpatient\Entities\RequestDischarge;
use Ignite\Inpatient\Entities\DischargeNote;
use Ignite\Inpatient\Entities\PatientAccount;
use Ignite\Evaluation\Entities\FinancePatientAccounts;
use Ignite\Evaluation\Entities\Investigations;
use Ignite\Evaluation\Entities\Prescriptions;
use Ignite\Inpatient\Entities\NursingCharge;
use Ignite\Inpatient\Entities\RequestAdmission;
use Ignite\Inpatient\Entities\Visit;
use Ignite\Inpatient\Entities\Ward;
use Ignite\Inpatient\Entities\WardAssigned;
use Ignite\Inpatient\Entities\Bed;
use Ignite\Inpatient\Entities\BedPosition;
use Ignite\Inpatient\Entities\Notes;
use Ignite\Inpatient\Entities\Vitals;
use Ignite\Reception\Entities\Patients;
use Ignite\Users\Entities\Roles;
use Ignite\Users\Entities\UserRoles;
use Ignite\Users\Entities\User;

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

	// public function getAllPatients(){
	// 	return $this->patients->latest()->get()->map(function ($item){
	// 		return  
	// 		[
	// 			"id"			=> $item->id,
	// 			"id_number" 	=> $item->id_no,
	// 			"profile"		=> $item->image,
	// 			"fullname" 		=> $item->fullName,
	// 			"registered" 	=> $item->registered
	// 		];
	// 	})->toJson();
	// }

	public function getPatientDetails($id){
		try{
	        $data = $this->admission->where('id', $id)->get()->map(function($item) {
	        	return 
	        	[
					"id"			=> $item->id,
					"patient_id"	=> $item->patient->id,
					"patient_no"	=> (isset($item->patient->patient_no)) ? $item->patient->patient_no  : "No Patient number assigned",
					"visit_id"		=> $item->visit_id,
					"id_number" 	=> (isset($item->patient->id_no)) ? $item->patient->id_no  : "No ID number",
					"age"			=> $item->patient->age,
					"profile_img"		=> $item->patient->image,
					"fullname" 		=> $item->patient->fullName,
					"sex"			=> $item->patient->sex,
					"registered" 	=> \Carbon\Carbon::parse($item->patient->created_at)->format('d/m/y H:i A'),
					"ward"			=> $item->ward->name,
					"bed"			=> $item->bed->number,
					"balance"		=> $item->patient->account->balance,
					"deposit"		=> null,
					"admitted_at"	=> \Carbon\Carbon::parse($item->created_at)->format('d/m/y H:i A')
				];
			})->toArray();

			return json_encode(['type' => 'success', 'data' => $data]);
		}catch(\Exception $e){
			return json_encode(['type' => 'error', 'message' => 'No patient data found']);
		}
	
	}

	// public function getPatientsAwaitingAdmission(){
	// 	return $this->request_admission->latest()->get()->map(function ($item){
	// 		return 
	// 		[
	// 			"id"			=> $item->id,
	// 			"visit_id"		=> $item->visit_id,
	// 			"id_number" 	=> $item->patient->id_no,
	// 			"profile"		=> $item->patient->image,
	// 			"fullname" 		=> $item->patient->fullName,
	// 			"requested" 	=> \Carbon\Carbon::parse($item->created_at)->format('d/m/y')
	// 		];
	// 	})->toJson();

	// }

	public function getPatientsAdmitted(){
		try{
			$data = $this->admission->get()->map(function ($item){

				return 
				[
					"id" 			=> $item->id,
					"visit_id"		=> $item->visit_id,
					"fullname" 		=> $item->patient->fullName,
					"doctor"		=> (is_null($item->doctor_id)) ? $item->external_doctor : $item->doctor->profile->fullName,
					"ward"			=> $item->ward->name,
					"bed"			=> $item->bed->number,
					"cost"			=> $item->cost,
					"admitted" 		=> \Carbon\Carbon::parse($item->created_at)->format('d/m/y H:i A')
				];
			})->toArray();

			return json_encode(['type' => 'success', 'data' => $data]);

		}catch(\Exception $e){
			return json_encode(['type' => 'error', 'message' => 'No patient vitals found']);
		}
	} 

	private function calculateBMI($weight, $height){
		return $weight / ($height * $height);
	}

	private function getBMIStatus($bmi){
		if( ( $bmi > 29.9))
            return "Obese";
        else if( $bmi < 30 && $bmi > 24.9)
            return "Overweight";
        else if( $bmi < 24.8 && $bmi > 18.5)
            return "Normal";
        else if( $bmi < 18.5)
            return "Underweight";
	}

	public function getPatientVitals($admission_id, $id, $visit_id){
		try{
			if(count(Vitals::where('admission_id', $admission_id)->get()) > 0){
				$dataArr = [];
				$data = Vitals::where('admission_id', $admission_id)->get()->map(function($item){
					//  return [\Carbon\Carbon::parse($item->created_at)->format('H:i A d/m/Y ') => [
					// 	"id" 					=> $item->id,
					// 	"height"				=> $item->height,
					// 	"weight"				=> $item->weight,
					// 	"bmi"					=> number_format($this->calculateBMI($item->weight, $item->height), 2),
					// 	"bmi_status"			=> $this->getBMIStatus($this->calculateBMI($item->weight, $item->height)),
					// 	"bp"					=> $item->bp_systolic."/".$item->bp_diastolic,
					// 	"pulse"					=> $item->pulse,
					// 	"respiration"			=> $item->respiration,
					// 	"temperature"			=> $item->temperature,
					// 	"temperature_location"	=> $item->temperature_location,
					// 	"oxygen"				=> $item->oxygen,
					// 	"waist"					=> $item->waist,
					// 	"hip"					=> $item->hip,
					// 	"blood_sugar"			=> $item->blood_sugar,
					// 	"blood_sugar_units"		=> $item->blood_sugar_units,
					// 	"allergies"				=> $item->allergies,
					// 	"chronic_illnesses"		=> $item->chronic_illnesses,
					// 	"nurse_notes"			=> $item->nurse_notes,
					// 	"nurse"					=> $item->nurse->profile->fullName
					// ]];
					return 
					[
						"id" 					=> $item->id,
						"height"				=> $item->height,
						"weight"				=> $item->weight,
						"bmi"					=> number_format($this->calculateBMI($item->weight, $item->height), 2),
						"bmi_status"			=> $this->getBMIStatus($this->calculateBMI($item->weight, $item->height)),
						"bp"					=> $item->bp_systolic."/".$item->bp_diastolic,
						"pulse"					=> $item->pulse,
						"respiration"			=> $item->respiration,
						"temperature"			=> $item->temperature,
						"temperature_location"	=> $item->temperature_location,
						"oxygen"				=> $item->oxygen,
						"waist"					=> $item->waist,
						"hip"					=> $item->hip,
						"blood_sugar"			=> $item->blood_sugar,
						"blood_sugar_units"		=> $item->blood_sugar_units,
						"allergies"				=> $item->allergies,
						"chronic_illnesses"		=> $item->chronic_illnesses,
						"nurse_notes"			=> $item->nurse_notes,
						"nurse"					=> $item->nurse->profile->fullName,
						"timestamp"				=> \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i A')
					];
				})->toArray();
				return json_encode(['type' => 'success', 'data' => $data]);
			}else{
				return json_encode(['type' => 'error', 'message' => 'No patient vitals found']);
			}
		}catch(\Exception $e){
			return json_encode(['type' => 'error', 'message' => 'An error occured fetching vitals. '. $e->getMessage() ]);
		}
	}

	public function savePatientVitals(Request $request){
		 \DB::beginTransaction();
        try{
            $v = Vitals::find("admission_id", $request->admission_id);
            if($v == null){
                Vitals::create($request->all());
            }else{
                $v->update($request->all());
            }
            \DB::commit();
            return Response::json(['type' => 'success', 'message' => 'Recorded patient\'s vitals successfully']);
        }catch(\Exception $e){
            \DB::rollback();
            return Response::json(['type' => 'error', 'message' => 'An error occured. '. $e->getMessage()]);
        }
	}

	public function updatePatientVitals(Request $request){

	}

	public function deletePatientVitals($id){

	}

	public function getAllInvestigations($admission_id, $id, $visit_id){
		try{
			$data = Investigations::where("visit", $visit_id)->where("type", 1)->get()->map(function($item){
				return 
				[
					"id" 					=> $item->id,
					"visit_id"				=> $item->visit,
					"type"					=> $item->type

				];

			})->toArray();
			return json_encode(['type' => 'success', 'data' => $data]);
		}catch(\Exception $e){
			return json_encode(['type' => 'error', 'message' => 'An error occured. No investigations found']);
		}
	}

	public function getAllPrescriptions($admission_id, $id, $visit_id){
		try {
			$data = Prescriptions::where("visit", $visit_id)->get()->map(function($item){
			return 
			[
				"id" 					=> $item->id,
				"patient_id"			=> $item->visits->patients->id,
				"visit_id"				=> $item->visit,
				"dose"					=> $item->dose,
				"drug"					=> $item->drug,
				"route"					=> $item->whereto,
				"method"				=> $item->method,
				"take"					=> $item->take,
				"duration"				=> $item->duration,
				"time_measure"			=> $item->time_measure,
				"fr_du"					=> $item->take ."/".$item->duration,
				"allow_sub"				=> $item->sub,
				"by"					=> $item->user->profile->fullName,
				"date"					=> \Carbon\Carbon::parse($item->updated_at)->format('H:i A d/m/Y ')

			];

		})->toArray();
		return json_encode(['type' => 'success', 'data' => $data]);
		} catch (\Exception $e) {
			return json_encode(['type' => 'error', 'message' => 'An error occured. No prescriptions found. '. $e->getMessage()]);
		}
	}

	// public function getAllDiagnosis($admission_id, $id, $visit_id){
	// 	//
	// }

	public function getAllPerfomedProcedures($admission_id, $id, $visit_id){

	}

	public function getAllQueuedProcedures($admission_id, $id, $visit_id){

	}

	public function getDoctorsNotes($admission_id, $id, $visit_id){
		try{
			$data = Notes::where("visit_id", $visit_id)->where("type", 1)->get()->map(function($item){
				return 
				[
					"id" 					=> $item->id,
					"visit_id"				=> $item->visit_id,
					"notes"					=> $item->notes,
					"name"					=> $item->users->profile->fullName,
					// "date"					=> \Carbon\Carbon::parse('created_at')->format('d/m/y H:i A')
				];
			})->toArray();
			return json_encode(['type' => 'success', 'data' => $data]);
		}catch(\Exception $e){
			return json_encode(['type' => 'error', 'message' => 'An error occured. Could not retrieve notes. '. $e->getMessage()]);
		}
	}

	public function getNursesNotes($admission_id, $id, $visit_id){
		try{
			$data = Notes::where("visit_id", $visit_id)->where("type", 0)->get()->map(function($item){
				return 
				[
					"id" 					=> $item->id,
					"visit_id"				=> $item->visit_id,
					"notes"					=> $item->notes,
					"name"					=> $item->users->profile->fullName,
					// "date"					=> \Carbon\Carbon::parse('created_at')->format('d/m/y H:i A')
				];
			})->toArray();
			return json_encode(['type' => 'success', 'data' => $data]);
		}catch(\Exception $e){
			return json_encode(['type' => 'error', 'message' => 'An error occured. Could not retrieve notes. '. $e->getMessage()]);
		}
	}

	public function getHeadInjuries($admission_id, $id, $visit_id){
		try{
			
		}catch(\Exception $e){
			return Response::json(['type' => 'error', 'message' => 'An error occured during fetching. '. $e->getMessage()]);
		}
	}

	public function getFluidBalances($admission_id, $id, $visit_id){
		try{
			
		}catch(\Exception $e){
			return Response::json(['type' => 'error', 'message' => 'An error occured during fetching. '. $e->getMessage()]);
		}
	}

	public function getBloodTransfusions($admission_id, $id, $visit_id){
		try{
			
		}catch(\Exception $e){
			return Response::json(['type' => 'error', 'message' => 'An error occured during fetching. '. $e->getMessage()]);
		}
	}

	public function addNote(Request $request){
		try{
			$n = new Notes;
			$n->visit_id = $request->visit_id;
			$n->notes = $request->notes;
			$n->type = $request->type;
			$n->user = $request->user;
			$n->save();
			return ($n->id > 0) ? Response::json(['type' => 'success', 'message' => 'Notes saved!']) : Response::json(['type' => 'error', 'message' => 'Your note could not be saved']);
		}catch(\Exception $e){
			return Response::json(['type' => 'error', 'message' => 'Your note could not be saved']);
		}
	}

	public function addInvestigation(Request $request){
		
	}

	public function addBloodTransfusions(Request $request){
		
	}

	public function administerPrescription(Request $request){
		
	}

}