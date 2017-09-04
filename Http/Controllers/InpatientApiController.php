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
use Ignite\Inpatient\Entities\Administration;
use Ignite\Inpatient\Entities\Deposit;
use Ignite\Inpatient\Entities\RequestDischarge;
use Ignite\Inpatient\Entities\DischargeNote;
use Ignite\Inpatient\Entities\PatientAccount;
use Ignite\Evaluation\Entities\FinancePatientAccounts;
use Ignite\Evaluation\Entities\Investigations;
use Ignite\Evaluation\Entities\Prescriptions;
use Ignite\Evaluation\Entities\Procedures;
use Ignite\Inpatient\Entities\NursingCharge;
use Ignite\Inpatient\Entities\RequestAdmission;
use Ignite\Inpatient\Entities\Visit;
use Ignite\Inpatient\Entities\Ward;
use Ignite\Inpatient\Entities\WardAssigned;
use Ignite\Inpatient\Entities\Bed;
use Ignite\Inpatient\Entities\BedPosition;
use Ignite\Inpatient\Entities\Notes;
use Ignite\Inpatient\Entities\Vitals;
use Ignite\Inpatient\Entities\HeadInjury;
use Ignite\Inpatient\Entities\FluidBalance;
use Ignite\Reception\Entities\Patients;
use Ignite\Users\Entities\Roles;
use Ignite\Users\Entities\UserRoles;
use Ignite\Users\Entities\User;

use Carbon\Carbon;

class InpatientApiController extends Controller
{
	private $admission;
	private $request_admission;
    private $roles;
    private $user_roles;
    private $user;
    private $patients;
    private $visit;
    private $carbon;
    private $tz;

	public function __construct(Carbon $carbon, Admission $admission, Patients $patients, RequestAdmission $request_admission, Roles $roles, User $user, UserRoles $user_roles, Visit $visit){

		$this->carbon = $carbon;
		$this->carbon->tz =  new \DateTimeZone('Africa/Nairobi');
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
					"registered" 	=> $this->carbon->parse($item->patient->created_at)->format('d/m/y H:i A'),
					"ward"			=> $item->ward->name,
					"bed"			=> $item->bed->number,
					"balance"		=> $item->patient->account->balance,
					"deposit"		=> null,
					"admitted_at"	=> $this->carbon->parse($item->created_at)->format('d/m/y H:i A')
				];
			})->toArray();

			return Response::json(['type' => 'success', 'data' => $data]);
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
	// 			"requested" 	=> $this->carbon->parse($item->created_at)->format('d/m/y')
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
					"admitted" 		=> $this->carbon->parse($item->created_at)->format('d/m/y H:i A')
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

	public function getPatientVitals($admission_id){
		try{
			if(count(Vitals::where('admission_id', $admission_id)->get()) > 0){
				$dataArr = [];
				$data = Vitals::where('admission_id', $admission_id)->orderBy("updated_at", "DESC")->get()->map(function($item){
					return 
					[
						"id" 					=> $item->id,
						"height"				=> $item->height,
						"weight"				=> $item->weight,
						"bmi"					=> number_format($this->calculateBMI($item->weight, $item->height), 2),
						"bmi_status"			=> $this->getBMIStatus($this->calculateBMI($item->weight, $item->height)),
						"bp_systolic"			=> $item->bp_systolic,
						"bp_diastolic"			=> $item->bp_diastolic,
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
						"recorded_by"			=> $item->user->profile->fullName,
						"timestamp"				=> $this->carbon->parse($item->created_at)->format('d/m/Y H:i A')
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

	public function saveUpdateVitals(Request $request){
		 \DB::beginTransaction();
        try{
            $v = Vitals::find("id", $request->id);
            if($v == null){
            	return Response::json(['type' => 'success', 'message' => 'saved']);
                // Vitals::create($request->all());
            }else{
            	return Response::json(['type' => 'success', 'message' => 'updated']);
                // $v->update($request->all());
            }
            \DB::commit();
            return Response::json(['type' => 'success', 'message' => 'Recorded patient\'s vitals successfully']);
        }catch(\Exception $e){
            \DB::rollback();
            return Response::json(['type' => 'error', 'message' => 'An error occured. '. $e->getMessage()]);
        }
	}

	public function deleteVitals(){
		\DB::beginTransaction();
		try{
			$v = Vitals::find("id", $request->id);
			$v->delete();
			if($v) {
				\DB::commit();
				return Response::json(['type' => 'success', 'message' => 'Vitals deleted successfully']);
			}else{
				\DB::rollback();
				return Response::json(['type' => 'error', 'message' => 'Could not delete vitals']);
			}
		}catch(\Exception $e){
            \DB::rollback();
            return Response::json(['type' => 'error', 'message' => 'An error occured. '. $e->getMessage()]);
        }
	}

	public function getProcedures(){
		try {
			$data = Procedures::whereCategory(6)->get()->toArray();
			return json_encode(['type' => 'success', 'data' => $data]);
		} catch (\Exception $e) {
			
		}
	}

	public function getSearchedProcedures(Request $request, $type) {
        $term = $request->term['term'];
        $build = [];
        $found = get_procedures_for($type, $term);

        $co = null;
        if (isset($request->visit)) {
            $visit = \Ignite\Evaluation\Entities\Visit::find($request->visit);
            if ($visit->payment_mode == 'insurance') {
                $co = $visit->patient_scheme->schemes->companies->id;
            }
        }

        foreach ($found as $val) {
            $c_price = \Ignite\Settings\Entities\CompanyPrice::whereCompany(intval($co))
                    ->whereProcedure(intval($val['id']))
                    ->get()
                    ->first();
            if (isset($c_price)) {
                if ($c_price->price > 0) {
                    $price = $c_price->price;
                }
            } else {
                $price = $val['cash_charge'];
            }
            $build[] = ['text' => $val['name'], 'id' => $val['id'], 'price' => $price];
        }
        return json_encode(['results' => $build]);
    }

	public function getAllInvestigations($admission_id){
		try{
			$data = Investigations::where("admission", $admission_id)->where("type", 1)->get()->map(function($item){
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

	public function getAllPrescriptions($admission_id){
		try {
			$data = Prescriptions::where("admission_id", $admission_id)->orderBy("updated_at", "DESC")->get()->map(function($item){
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
				"date"					=> $this->carbon->parse($item->updated_at)->format('H:i A d/m/Y ')

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

	public function getAllPerfomedProcedures($admission_id){

	}

	public function getAllQueuedProcedures($admission_id){

	}

	public function getNotes($admission_id, $type){
		try{
			$data = Notes::where("admission_id", $admission_id)->where("type", $type)->orderBy("updated_at", "DESC")->get()->map(function($item){
				return 
				[
					"id" 					=> $item->id,
					"admission_id"			=> $item->admission_id,
					"visit_id"				=> $item->visit_id,
					"notes"					=> $item->notes,
					"name"					=> $item->users->profile->fullName,
					"written_on"			=> $this->carbon->parse($item->created_at)->format('d/m/y H:i A')
				];
			})->toArray();
			return json_encode(['type' => 'success', 'data' => $data]);
		}catch(\Exception $e){
			return json_encode(['type' => 'error', 'message' => 'An error occured. Could not retrieve notes. '. $e->getMessage()]);
		}
	}


	public function getHeadInjuries($admission_id){
		try{
			$data = HeadInjury::where("admission_id", $admission_id)->orderBy("updated_at", "DESC")->get()->map(function($item){
				return 
				[
					"id" 					=> $item->id,
					"admission_id"			=> $item->admission_id,
					"bp_systolic"			=> $item->bp_systolic,
					"bp_diastolic"			=> $item->bp_diastolic,
					"pulse"					=> $item->pulse,
					"respiration"			=> $item->respiration,
					"temperature"			=> $item->temperature,
					"conscious_status"		=> unserialize($item->conscious_status),
					"pupil_status"			=> unserialize($item->pupil_status),
					"user"					=> $item->users->profile->fullName,
					"recorded_on"			=> $this->carbon->parse($item->created_at)->format('d/m/y H:i A')
				];
			})->toArray();

			return json_encode(['type' => 'success', 'data' => $data]);
			
		}catch(\Exception $e){
			return Response::json(['type' => 'error', 'message' => 'An error occured during fetching. '. $e->getMessage()]);
		}
	}

	public function getFluidBalances($admission_id){
		try{
			$data = FluidBalance::where("admission_id", $admission_id)->orderBy("updated_at", "DESC")->get()->map(function($item){
				return 
				[
					"id" 					=> $item->id,
					"admission_id"			=> $item->admission_id,
				];
			})->toArray();
			
			return json_encode(['type' => 'success', 'data' => $data]);

		}catch(\Exception $e){
			return Response::json(['type' => 'error', 'message' => 'An error occured during fetching. '. $e->getMessage()]);
		}
	}

	public function getBloodTransfusions($admission_id){
		try{
			
		}catch(\Exception $e){
			return Response::json(['type' => 'error', 'message' => 'An error occured during fetching. '. $e->getMessage()]);
		}
	}

	public function addNote(Request $request){
		try{
			$request = $request->json()->all();
			$n = new Notes;
			$n->visit_id = $request['visit_id'];
			$n->admission_id = $request['admission_id'];
			$n->notes = $request['notes'];
			$n->type = $request['type'];
			$n->user = $request['user'];
			$n->save();
			return ($n->id > 0) ? Response::json(['type' => 'success', 'message' => 'Notes saved!', 'data' => $this->getNoteData($n->id, $n->type)]) : Response::json(['type' => 'error', 'message' => 'Your note could not be saved']);
		}catch(\Exception $e){
			return Response::json(['type' => 'error', 'message' => 'Your note could not be saved. '. $e->getMessage()]);
		}
	}

	public function getNoteData($id){
		try{
			$data =  Notes::where("id", $id)->get()->map(function($item){
				return 
				[
					"id" 					=> $item->id,
					"admission_id"			=> $item->admission_id,
					"visit_id"				=> $item->visit_id,
					"notes"					=> $item->notes,
					"name"					=> $item->users->profile->fullName,
					"written_on"			=> $this->carbon->parse($item->created_at)->format('d/m/y H:i A')
				];
			})->toArray();
			return json_encode($data);
		}catch(\Exception $e){
			return $e->getMessage();
		}
	}

	public function updateNote(Request $request, $id){
		try{
			$request = $request->json()->all();
			$n = Notes::find($id);
			$n->notes = $request['notes'];
			// $n->user = $request['user'];
			$n->save();
			return ($n) ? Response::json(['type' => 'success', 'message' => 'Note updated!']) : Response::json(['type' => 'error', 'message' => 'Your note could not be updated']);
		}catch(\Exception $e){
			return Response::json(['type' => 'error', 'message' => 'Your note could not be updated. '. $e->getMessage()]);
		}
	}

	public function deleteNote(Request $request, $id){
		try{
			$request = $request->json()->all();
			$n = Notes::find($id);
			$n->delete();
			return ($n) ? Response::json(['type' => 'success', 'message' => 'Note deleted!']) : Response::json(['type' => 'error', 'message' => 'Your note could not be deleted']);
		}catch(\Exception $e){
			return Response::json(['type' => 'error', 'message' => 'Your note could not be deleted. '. $e->getMessage()]);
		}
	}

	public function addHeadInjury(Request $request){
		try{
			$request = $request->json()->all();
			$h = new HeadInjury;
			$h->bp_systolic			= $request['bp_systolic'];
			$h->bp_diastolic		= $request['bp_diastolic'];
			$h->pulse				= $request['pulse'];
			$h->respiration			= $request['respiration'];
			$h->temperature			= $request['temperature'];
			$h->conscious_status	= serialize($request['conscious_status']);
			$h->pupil_status		= serialize($request['pupil_status']);
			$h->user				= $request['user'];
			$h->save();
			return ($n->id > 0) ? Response::json(['type' => 'success', 'message' => 'Head Injury & Craniotomy data saved!']) : Response::json(['type' => 'error', 'message' => 'The Head Injury & Craniotomy data could not be saved']);
		}catch(\Exception $e){
			return Response::json(['type' => 'error', 'message' => 'The Head Injury & Craniotomy data could not be saved. '. $e->getMessage()]);
		}
	}

	public function updateHeadInjury(Request $request, $id){
		try{
			$request = $request->json()->all();
			$n = HeadInjury::find($id);
			$h->bp_systolic			= $request['bp_systolic'];
			$h->bp_diastolic		= $request['bp_diastolic'];
			$h->pulse				= $request['pulse'];
			$h->respiration			= $request['respiration'];
			$h->temperature			= $request['temperature'];
			$h->conscious_status	= $request['conscious_status'];
			$h->pupil_status		= $request['pupil_status'];
			$h->user				= $request['user'];
			$h->save();
			$n->save();
			return ($n->id > 0) ? Response::json(['type' => 'success', 'message' => 'Head Injury & Craniotomy data updated!']) : Response::json(['type' => 'error', 'message' => 'The Head Injury & Craniotomy data could not be updated']);
		}catch(\Exception $e){
			return Response::json(['type' => 'error', 'message' => 'The Head Injury & Craniotomy data could not be updated. '. $e->getMessage()]);
		}
	}

	public function deleteHeadInjury(Request $request, $id){
		try{
			$request = $request->json()->all();
			$h = HeadInjury::find($id);
			$h->delete();
			return ($h) ? Response::json(['type' => 'success', 'message' => 'Head Injury & Craniotomy data deleted!']) : Response::json(['type' => 'error', 'message' => 'The Head Injury & Craniotomy data could not be deleted']);
		}catch(\Exception $e){
			return Response::json(['type' => 'error', 'message' => 'The Head Injury & Craniotomy data could not be deleted. '. $e->getMessage()]);
		}
	}

	public function addInvestigation(Request $request){
		
	}

	public function addBloodTransfusions(Request $request){
		
	}

	public function addPrescription(Request $request){

	}

	public function updatePrescription(Request $request, $id){

	}

	public function deletePrescription(Request $request, $id){
		
	}

	public function administerPrescription(Request $request){
		try{
			$request = $request->json()->all();
			$a = new Administration;
			$a->admission_id = $request['admission_id'];
			$a->prescription_id	= $request['prescription_id'];
			$a->time = $request['time'];
			$a->am_pm = $request['am_pm'];
			$a->user = $request['user'];
			$a->save();

			return ($a->id > 0) ? Response::json(['type' => 'success', 'message' => 'The prescribed drug has been administered!']) : Response::json(['type' => 'error', 'message' => 'The prescription could not be administered']);
		}catch(\Exception $e){
			return Response::json(['type' => 'error', 'message' => 'An error occured. The drug could not be administered. '. $e->getMessage()]);
		}
	}

	public function updateAdministeredPrescriptionLog(Request $request, $id){
		
	}

	public function deleteAdministeredPrescriptionLog(Request $request, $id){
		
	}

}