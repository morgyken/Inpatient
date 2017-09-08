<?php

namespace Ignite\Inpatient\Http\Controllers;

use Ignite\Inpatient\Entities\BloodPressure;
use Ignite\Inpatient\Entities\Temperature;
use Illuminate\Http\Request;
// use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Response;
use Validator;
use DB;

use Ignite\Inpatient\Entities\Admission;
use Ignite\Inpatient\Entities\Administration;
use Ignite\Inpatient\Entities\Deposit;
use Ignite\Inpatient\Entities\RequestDischarge;
use Ignite\Inpatient\Entities\DischargeNote;
use Ignite\Inpatient\Entities\PatientAccount;
use Ignite\Inpatient\Entities\Prescription;
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

use Ignite\Evaluation\Entities\FinancePatientAccounts;
use Ignite\Evaluation\Entities\Investigations;
use Ignite\Evaluation\Entities\Procedures;
use Ignite\Evaluation\Entities\VisitDestinations;

use Ignite\Reception\Entities\Patients;

use Ignite\Users\Entities\Roles;
use Ignite\Users\Entities\UserRoles;
use Ignite\Users\Entities\User;

use Ignite\Inventory\Entities\InventoryProducts;
use Ignite\Inventory\Entities\InventoryBatchPurchases;
use Ignite\Inventory\Entities\InventoryProductPrice;

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

    public function __construct(Carbon $carbon, Admission $admission, Patients $patients, RequestAdmission $request_admission, Roles $roles, User $user, UserRoles $user_roles, Visit $visit)
    {

        $this->carbon = $carbon;
        $this->carbon->tz = new \DateTimeZone('Africa/Nairobi');
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

    public function getPatientDetails($id)
    {
        try {
            $data = $this->admission->where('id', $id)->get()->map(function ($item) {
                return
                    [
                        "id" => $item->id,
                        "patient_id" => $item->patient->id,
                        "patient_no" => (isset($item->patient->patient_no)) ? $item->patient->patient_no : "No Patient number assigned",
                        "visit_id" => $item->visit_id,
                        "id_number" => (isset($item->patient->id_no)) ? $item->patient->id_no : "No ID number",
                        "age" => $item->patient->age,
                        "profile_img" => $item->patient->image,
                        "fullname" => $item->patient->fullName,
                        "sex" => $item->patient->sex,
                        "registered" => $this->carbon->parse($item->patient->created_at)->format('d/m/y H:i A'),
                        "ward" => $item->ward->name,
                        "bed" => $item->bed->number,
                        "balance" => (isset($item->patient->account->balance)) ? $item->patient->account->balance : 0,
                        "deposit" => null,
                        "admitted_at" => $this->carbon->parse($item->created_at)->format('d/m/y H:i A')
                    ];
            })->toArray();

            return (count($data) > 0) ? Response::json(['type' => 'success', 'data' => $data]) : Response::json(['type' => 'error', 'message' => 'No patient data found']);
        } catch (\Exception $e) {
            return Response::json(['type' => 'error', 'message' => 'An error occured. No patient data could be retrieved.' . $e->getMessage()]);
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

    public function getPatientsAdmitted()
    {
        try {
            $data = $this->admission->get()->map(function ($item) {

                return
                    [
                        "id" => $item->id,
                        "visit_id" => $item->visit_id,
                        "fullname" => $item->patient->fullName,
                        "doctor" => (is_null($item->doctor_id)) ? $item->external_doctor : $item->doctor->profile->fullName,
                        "ward" => $item->ward->name,
                        "bed" => $item->bed->number,
                        "cost" => $item->cost,
                        "admitted" => $this->carbon->parse($item->created_at)->format('d/m/y H:i A')
                    ];
            })->toArray();

            return json_encode(['type' => 'success', 'data' => $data]);

        } catch (\Exception $e) {
            return json_encode(['type' => 'error', 'message' => 'No patient vitals found']);
        }
    }

    private function calculateBMI($weight, $height)
    {
        try {
            return $weight / ($height * $height);
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function getBMIStatus($bmi)
    {
        if (($bmi > 29.9))
            return "Obese";
        else if ($bmi < 30 && $bmi > 24.9)
            return "Overweight";
        else if ($bmi < 24.8 && $bmi > 18.5)
            return "Normal";
        else if ($bmi < 18.5)
            return "Underweight";
    }

    public function getPatientVitals($admission_id)
    {
        try {
            if (count(Vitals::where('admission_id', $admission_id)->get()) > 0) {
                $dataArr = [];
                $data = Vitals::where('admission_id', $admission_id)->orderBy("updated_at", "DESC")->get()->map(function ($item) {
                    return
                        [
                            "id" => $item->id,
                            "height" => $item->height,
                            "weight" => $item->weight,
                            "bmi" => number_format($this->calculateBMI($item->weight, $item->height), 2),
                            "bmi_status" => $this->getBMIStatus($this->calculateBMI($item->weight, $item->height)),
                            "bp_systolic" => $item->bp_systolic,
                            "bp_diastolic" => $item->bp_diastolic,
                            "bp" => $item->bp_systolic . "/" . $item->bp_diastolic,
                            "pulse" => $item->pulse,
                            "respiration" => $item->respiration,
                            "temperature" => $item->temperature,
                            "temperature_location" => $item->temperature_location,
                            "oxygen" => $item->oxygen,
                            "waist" => $item->waist,
                            "hip" => $item->hip,
                            "blood_sugar" => $item->blood_sugar,
                            "blood_sugar_units" => $item->blood_sugar_units,
                            "allergies" => $item->allergies,
                            "chronic_illnesses" => $item->chronic_illnesses,
                            "recorded_by" => $item->user->profile->fullName,
                            "timestamp" => $this->carbon->parse($item->created_at)->format('d/m/Y H:i A')
                        ];
                })->toArray();
                return json_encode(['type' => 'success', 'data' => $data]);
            } else {
                return json_encode(['type' => 'success', 'message' => 'No patient vitals found', 'data' => []]);
            }
        } catch (\Exception $e) {
            return json_encode(['type' => 'error', 'message' => 'An error occured fetching vitals. ' . $e->getMessage()]);
        }
    }

    public function saveUpdateVitals(Request $request)
    {
        \DB::beginTransaction();
        try {
            $request = $request->json()->all();

            if (in_array('id', $request)) {
                $v = Vitals::find("id", $request['id']);
                if ($v != null) {
                    $v->update($request);
                    \DB::commit();
                    return Response::json(['type' => 'success', 'message' => 'Updated patient\'s vitals successfully']);
                }
            } else {
                $v = new Vitals;
                $v->admission_id = $request['admission_id'];
                $v->bp_systolic = $request['bp_systolic'];
                $v->bp_diastolic = $request['bp_diastolic'];
                $v->pulse = $request['pulse'];
                $v->respiration = $request['respiration'];
                $v->temperature = $request['temperature'];
                $v->temperature_location = $request['temperature_location'];
                $v->oxygen = $request['oxygen'];
                $v->user_id = $request['user_id'];
                $v->date_recorded = $this->carbon->now();
                $v->save();

                if ($v->id > 0) {
                    \DB::commit();
                    return Response::json(['type' => 'success', 'message' => 'Recorded patient\'s vitals successfully']);
                } else {
                    \DB::rollback();
                    return Response::json(['type' => 'error', 'message' => 'An error occured during saving']);
                }
            }
        } catch (\Exception $e) {
            \DB::rollback();
            return Response::json(['type' => 'error', 'message' => 'An error occured. ' . $e->getMessage()]);
        }
    }

    public function deleteVitals()
    {
        \DB::beginTransaction();
        try {
            $request = $request->json()->all();
            $v = Vitals::find("id", $request['id']);
            $v->delete();
            if ($v) {
                \DB::commit();
                return Response::json(['type' => 'success', 'message' => 'Vitals deleted successfully']);
            } else {
                \DB::rollback();
                return Response::json(['type' => 'error', 'message' => 'Could not delete vitals']);
            }
        } catch (\Exception $e) {
            \DB::rollback();
            return Response::json(['type' => 'error', 'message' => 'An error occured. ' . $e->getMessage()]);
        }
    }

    public function getAllProcedures()
    {
        try {
            $data = Procedures::whereCategory(6)->get()->toArray();
            return json_encode(['type' => 'success', 'data' => $data]);
        } catch (\Exception $e) {
            return Response::json(['type' => 'error', 'message' => 'An error occured. ' . $e->getMessage()]);
        }
    }

    public function getSearchedProcedures(Request $request, $type)
    {
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

	public function getAllInvestigations($visit_id){
		try{
			$data = Investigations::where("visit", $visit_id)->get()->map(function($item){
				return 
				[
					"id" 					=> $item->id,
					"visit_id"				=> $item->visit,
					"type"					=> $item->type,
					"procedure"				=> $item->procedures->name,
					"quantity"				=> $item->quantity,
					"price"					=> $item->price,
					"discount"				=> $item->discount,
					"amount"				=> $item->amount,
					"user"					=> $item->doctors->profile->fullName,
					"instructions"			=> $item->instructions,
					"ordered"				=> $item->ordered,
					"invoiced"				=> $item->invoiced,
					"requested_on"			=> $this->carbon->parse($item->updated_at)->format('H:i A d/m/Y ')
				];

			})->toArray();
			return json_encode(['type' => 'success', 'data' => $data]);
		}catch(\Exception $e){
			return json_encode(['type' => 'error', 'message' => 'An error occured. No investigations found. '. $e->getMessage()]);
		}
	}

	public function getAllPrescriptions($admission_id, $type){
		try {
			$data = Prescription::where("admission_id", $admission_id)->where("type", $type)->whereHas('dispensing', function ($query) {
                        $query->whereHas('visits', function ($q) {
                            $q->whereId(\Session::get('v'));
                        });
                    })->orderBy("updated_at", "DESC")->get()->map(function($item){
			return 
			[
				"id" 					=> $item->id,
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
				"by"					=> $item->users->profile->fullName,
				"status"				=> $item->status,
				"prescribed_on"			=> $this->carbon->parse($item->updated_at)->format('H:i A d/m/Y ')

			];

		})->toArray();
			return json_encode(['type' => 'success', 'data' => $data]);
		} catch (\Exception $e) {
			return json_encode(['type' => 'error', 'message' => 'An error occured. No prescriptions found. '. $e->getMessage()]);
		}
	}

	public function cancelPrescription(Request $request){
		\DB::beginTransaction();
		try{
			$request = $request->json()->all();
			$p = Prescription::find("id", $request['id']);
			$p->status = 1;
			if($p) {
				\DB::commit();
				return Response::json(['type' => 'success', 'message' => 'Prescription canceled']);
			}else{
				\DB::rollback();
				return Response::json(['type' => 'error', 'message' => 'Could not cancel prescription']);
			}
		}catch(\Exception $e){
			return Response::json(['type' => 'error', 'message' => 'An error occured. The prescription could not be canceled. '. $e->getMessage()]);
		}
	}

	// public function getAllDiagnosis($admission_id, $id, $visit_id){
	// 	//
	// }

	public function getProcedures($admission_id, $visit_id){
		\DB::beginTransaction();
		try{
			// $data = 

		}catch(\Exception $e){
			return Response::json(['type' => 'error', 'message' => 'An error occured. The procedures could not be retrieved. '. $e->getMessage()]);
		}

	}

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
		\DB::beginTransaction();
		try{
			$request = $request->json()->all();
			$n = Notes::create($request);
			\DB::commit();
			return ($n->id > 0) ? Response::json(['type' => 'success', 'message' => 'Notes saved!', 'data' => $this->getNoteData($n->id, $n->type)]) : Response::json(['type' => 'error', 'message' => 'Your note could not be saved']);
		}catch(\Exception $e){
			\DB::rollback();
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

	public function deleteNote(Request $request){
		try{
			$request = $request->json()->all();
			$n = Notes::find($request['id']);
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

	public function addInvestigations(Request $request){
		try{
			$request = $request->json()->all();

			return $request;

		}catch(\Exception $e){
			return Response::json(['type' => 'error', 'message' => 'An error occured. The investigation could not be added. '. $e->getMessage()]);
		}

	}

	public function addBloodTransfusions(Request $request){
		
	}

	public function getDrug($term){
		try{
			$found = collect();
	        $ret = [];
	       
	        if (!empty($term)) {
	            $found = InventoryProducts::with(['prices' => function($query) {

		            }])->with(['stocks' => function($query) {

		            }])
		        ->where('name', 'like', "%$term%")->get();
	        }

	        $build = [];
	        foreach ($found as $item) {
	            $batchp = InventoryBatchPurchases::whereProduct($item->id)
	                    ->whereActive(TRUE)
	                    ->first();
	            $this->data['item_prices'] = InventoryProductPrice::query()
	                            ->where('product', '=', $item->id)->get();
	            $active_price = 0.00;
	            foreach ($this->data['item_prices'] as $product) {
	                if ($product->price > $active_price) {
	                    $active_price = $product->price;
	                }
	            }
	            $expiry = empty($batchp->expiry_date) ? '' : ' |expiry: ' . $batchp->expiry_date;
	            $stock_text = empty($item->stocks) ? '  Out of stock' : $item->stocks->quantity . ' in stock';
	            $strngth_text = empty($item->strength) ? '' : ' | ' . $item->strength . $item->units->name;
	            $build[] = [
	                'text' => $item->name . '  - ' . $stock_text . $strngth_text . $expiry,
	                'id' => $item->id,
	                'batch' => empty($batchp->batch) ? 0 : $batchp->batch,
	                'cash_price' => ceil(($item->categories->cash_markup + 100) / 100 * $active_price), //$item->prices->credit_price
	                'credit_price' => ceil(($item->categories->credit_markup + 100) / 100 * $active_price),
	                'o_price' => ceil($active_price),
	                'available' => empty($item->stocks) ? 0 : $item->stocks->quantity];
	        }
	        $ret['results'] = $build;
	        return json_encode(['type' => 'success', 'data' => $ret]);
    	}catch (\Exception $e) {
			return Response::json(['type' => 'error', 'message' => 'An error occured. The drug could not be found. '. $e->getMessage()]);
		}
	}

	public function addPrescription(Request $request){
		\DB::beginTransaction();
		try {
			$request = $request->json()->all();
			$p = new Prescription;
			$p->admission_id 		= $request['admission_id']; 
			$p->visit 				= $request['visit'];
			$p->drug 				= $request['drug']; 
			$p->take 				= $request['take'];
			$p->whereto 			= $request['whereto']; 
			$p->method 				= $request['method']; 
			$p->duration 			= $request['duration'];
			$p->allow_substitution 	= $request['allow_substitution'];
			$p->time_measure 		= $request['time_measure'];
			$p->user 				= $request['user'];
			$p->type 				= $request['type'];
			$p->save();

			// Add to Prescription Queue

			$this->checkInAt($request['visit'], 'pharmacy');

			if($p) {
				\DB::commit(); 
				return Response::json(['type' => 'success', 'message' => 'The prescription has been added.']);
			}else{
				\DB::rollback();
				return Response::json(['type' => 'error', 'message' => 'An error occured while saving. Please try again!']);
			}
		} catch (\Exception $e) {
			return Response::json(['type' => 'error', 'message' => 'An error occured. The prescription could not be added. '. $e->getMessage()]);
		}
	}

	 private function checkInAt($visit_id, $place) {
        $department = $place;
        $destination = NULL;
        if (intval($place) > 0) {
            $destination = (int) $department;
            $department = 'doctor';
        }
        $destinations = VisitDestinations::firstOrNew(['visit' => $visit_id, 'department' => ucwords($department)]);
        $destinations->destination = $destination;
        $destinations->user = \Auth::user()->id;
        $destinations->save();
    }

	public function updatePrescription(Request $request, $id){
		\DB::beginTransaction();
		try {
			$request = $request->json()->all();
			$p = Prescription::find($id);
			$p->admission_id 		= $request['admission_id']; 
			$p->drug 				= $request['drug']; 
			$p->whereto 			= $request['whereto']; 
			$p->method 				= $request['method']; 
			$p->duration 			= $request['duration'];
			$p->allow_substitution 	= $request['allow_substitution'];
			$p->time_measure 		= $request['time_measure'];
			$p->save();
			
			if($p) { 
				\DB::commit();
				return Response::json(['type' => 'success', 'message' => 'The prescription has been updated. ']);
			}else{
				\DB::rollback();
				return Response::json(['type' => 'error', 'message' => 'An error occured. The prescription could not be updated.']);
			}
		} catch (\Exception $e) {
			return Response::json(['type' => 'error', 'message' => 'An error occured. The prescription could not be added. '. $e->getMessage()]);
		}
	}

	public function deletePrescription(Request $request){
		\DB::beginTransaction();
		try{
			$request = $request->json()->all();
			$p = Prescription::find("id", $request['id']);
			$p->delete();
			if($p) {
				\DB::commit();
				return Response::json(['type' => 'success', 'message' => 'Prescription canceled successfully']);
			}else{
				\DB::rollback();
				return Response::json(['type' => 'error', 'message' => 'Could not cancel prescription']);
			}
		}catch(\Exception $e){
			return Response::json(['type' => 'error', 'message' => 'An error occured. The prescription could not be canceled. '. $e->getMessage()]);
		}
	}

    

    public function administerPrescription(Request $request)
    {
        try {
            $request = $request->json()->all();
            $a = new Administration;
            $a->admission_id = $request['admission_id'];
            $a->prescription_id = $request['prescription_id'];
            $a->time = $request['time'];
            $a->am_pm = $request['am_pm'];
            $a->user = $request['user'];
            $a->save();

            // Update inventory


            return ($a->id > 0) ? Response::json(['type' => 'success', 'message' => 'The prescribed drug has been administered!']) : Response::json(['type' => 'error', 'message' => 'The prescription could not be administered']);
        } catch (\Exception $e) {
            return Response::json(['type' => 'error', 'message' => 'An error occured. The drug could not be administered. ' . $e->getMessage()]);
        }
    }

    public function updateAdministeredPrescriptionLog(Request $request)
    {
        try {
            $request = $request->json()->all();
            $a = Administration::find($request['id']);
            $a->prescription_id = $request['prescription_id'];
            $a->time = $request['time'];
            $a->am_pm = $request['am_pm'];
            $a->user = $request['user'];
            $a->save();

            return ($a) ? Response::json(['type' => 'success', 'message' => 'The drug administration log has been updated!']) : Response::json(['type' => 'error', 'message' => 'The drug administration log could not be updated']);
        } catch (\Exception $e) {
            return Response::json(['type' => 'error', 'message' => 'An error occured. The drug administration logs could not be updated. ' . $e->getMessage()]);
        }
    }

    public function deleteAdministeredPrescriptionLog(Request $request)
    {
        try {
            $request = $request->json()->all();
            $a = Administration::find($request['id']);
            $a->delete();
            return ($a) ? Response::json(['type' => 'success', 'message' => 'The drug administration log has been deleted!']) : Response::json(['type' => 'error', 'message' => 'The drug administration log could not be deleted']);
        } catch (\Exception $e) {
            return Response::json(['type' => 'error', 'message' => 'An error occured. The drug administration logs could not be deleted. ' . $e->getMessage()]);
        }
    }

    public function getNursingCarePlans($id)
    {
        try {
            $request = $request->json()->all();
            // $data = ::where("admission_id", $id)->get()->map(function($item){
            // 	return
            // })->toArray();

            // return ($data) ? Response::json(['type' => 'success', 'data' => $data]) : Response::json(['type' => 'error', 'message' => 'The nursing care plans could not be deleted']);
        } catch (\Exception $e) {
            return Response::json(['type' => 'error', 'message' => 'An error occured. The nursing care plans could not be retrieved. ' . $e->getMessage()]);
        }
    }

    public function addNursingCarePlan(Request $request)
    {
        try {
            $request = $request->json()->all();
            // $n = ::find($request['id']);

            // return ($n) ? Response::json(['type' => 'success', 'message' => 'The drug administration log has been saved!']) : Response::json(['type' => 'error', 'message' => 'The drug administration log could not be saved']);
        } catch (\Exception $e) {
            return Response::json(['type' => 'error', 'message' => 'An error occured. The nursing care plan could not be saved. ' . $e->getMessage()]);
        }
    }

    public function updateNursingCarePlan(Request $request)
    {
        try {
            $request = $request->json()->all();
            // $n = ::find($request['id']);
            // return ($n) ? Response::json(['type' => 'success', 'message' => 'The nursing care plan has been updated!']) : Response::json(['type' => 'error', 'message' => 'The nursing care plan could not be updated']);
        } catch (\Exception $e) {
            return Response::json(['type' => 'error', 'message' => 'An error occured. The nursing care plan could not be updated. ' . $e->getMessage()]);
        }
    }

    public function deleteNursingCarePlan(Request $request)
    {
        try {
            $request = $request->json()->all();
            // $n = ::find($request['id']);
            // $n->delete();
            // return ($n) ? Response::json(['type' => 'success', 'message' => 'The nursing care plan has been deleted!']) : Response::json(['type' => 'error', 'message' => 'The nursing care plan could not be deleted']);
        } catch (\Exception $e) {
            return Response::json(['type' => 'error', 'message' => 'An error occured. The nursing care plan could not be deleted. ' . $e->getMessage()]);
        }
    }

}