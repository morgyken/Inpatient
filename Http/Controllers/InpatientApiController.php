<?php

/*
    |--------------------------------------------------------------------------
    | INPATIENT V1 API - It's a crazy mess this one coz of insane timelines!!!
    | 
    | AUTHOR: DAVID NGUGI ( dngugi@collabmed.com )
    | 
    | DATE: AUGUST/SEPTEMBER 2017
    | 
    |--------------------------------------------------------------------------
*/

namespace Ignite\Inpatient\Http\Controllers;

use Carbon\Carbon;
use Ignite\Finance\Entities\PatientAccount;
use Ignite\Evaluation\Entities\Investigations;
use Ignite\Evaluation\Entities\Procedures;
use Ignite\Evaluation\Entities\VisitDestinations;
use Ignite\Evaluation\Entities\RecurrentCharge;
use Ignite\Inpatient\Entities\Administration;
use Ignite\Inpatient\Entities\Admission;
use Ignite\Inpatient\Entities\BloodPressure;
use Ignite\Inpatient\Entities\BloodTransfusion;
use Ignite\Inpatient\Entities\CanceledPrescriptions;
use Ignite\Inpatient\Entities\FluidBalance;
use Ignite\Inpatient\Entities\HeadInjury;
use Ignite\Inpatient\Entities\InpatientConsumable;
use Ignite\Inpatient\Entities\Notes;
use Ignite\Inpatient\Entities\NursingCarePlan;
use Ignite\Inpatient\Entities\NursingCharge;
use Ignite\Inpatient\Entities\Prescription;
use Ignite\Inpatient\Entities\PatientAccount;
use Ignite\Inpatient\Entities\RequestAdmission;
use Ignite\Inpatient\Entities\RequestDischarge;
use Ignite\Inpatient\Entities\Temperature;
use Ignite\Inpatient\Entities\Visit;
use Ignite\Inpatient\Entities\Vitals;
use Ignite\Inpatient\Entities\WardAssigned;
use Ignite\Inpatient\Helpers\InpatientHelpers;
use Ignite\Inventory\Entities\InventoryBatchPurchases;
use Ignite\Inventory\Entities\InventoryProductPrice;
use Ignite\Inventory\Entities\InventoryProducts;
use Ignite\Reception\Entities\Patients;
use Ignite\Users\Entities\Roles;
use Ignite\Users\Entities\User;
use Ignite\Users\Entities\UserRoles;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Response;

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
    private $helper;

    public function __construct(InpatientHelpers $helper, Carbon $carbon, Admission $admission, Patients $patients, RequestAdmission $request_admission, Roles $roles, User $user, UserRoles $user_roles, Visit $visit)
    {

        $this->helper = $helper;
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

    public function getPatientVitals($admission_id)
    {
        try {
            if (count(Vitals::where('admission_id', $admission_id)->get()) > 0) {
                $data = Vitals::where('admission_id', $admission_id)->orderBy("updated_at", "DESC")->get()->map(function ($item) {
                    return
                        [
                            "id" => $item->id,
                            "height" => $item->height,
                            "weight" => $item->weight,
                            "bmi" => number_format($this->helper->calculateBMI($item->weight, $item->height), 2),
                            "bmi_status" => $this->helper->getBMIStatus($this->helper->calculateBMI($item->weight, $item->height)),
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
                            "date_time_recorded" => $item->date_recorded . " " . $item->time_recorded,
                            "timestamp" => $this->carbon->parse($item->created_at)->format('d/m/Y H:i A')
                        ];
                })->toArray();
                return json_encode(['type' => 'success', 'data' => $data]);
            } else {
                return json_encode(['type' => 'success', 'message' => 'No patient vitals found']);
            }
        } catch (\Exception $e) {
            return json_encode(['type' => 'error', 'message' => 'An error occured fetching vitals. ' . $e->getMessage()]);
        }
    }

    public function getPatientVital($id)
    {
        try {
            if (count(Vitals::where('id', $id)->get()) > 0) {
                $data = Vitals::where('id', $id)->first()->map(function ($item) {
                    return
                        [
                            "id" => $item->id,
                            "height" => $item->height,
                            "weight" => $item->weight,
                            "bmi" => number_format($this->helper->calculateBMI($item->weight, $item->height), 2),
                            "bmi_status" => $this->helper->getBMIStatus($this->helper->calculateBMI($item->weight, $item->height)),
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
                            "date_time_recorded" => $item->date_recorded . " " . $item->time_recorded
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
                $v->visit_id                = $request['visit_id'];
                $v->admission_id            = $request['admission_id'];
                $v->height                  = $request['height'];
                $v->weight                  = $request['weight'];
                $v->bp_systolic             = $request['bp_systolic'];
                $v->bp_diastolic            = $request['bp_diastolic'];
                $v->pulse                   = $request['pulse'];
                $v->respiration             = $request['respiration'];
                $v->temperature             = $request['temperature'];
                $v->temperature_location    = $request['temperature_location'];
                $v->oxygen                  = $request['oxygen'];
                $v->waist                   = $request['waist'];
                $v->hip                     = $request['hip'];
                $v->blood_sugar             = $request['blood_sugar'];
                $v->blood_sugar_units       = $request['blood_sugar_units'];
                $v->allergies               = $request['allergies'];
                $v->chronic_illnesses       = $request['chronic_illnesses'];
                $v->user_id                 = $request['user_id'];
                $v->date_recorded           = $request['date_recorded']; 
                $v->time_recorded           = $request['time_recorded'];
                $v->save();

                if ($v) {
                    \DB::commit();
                    return Response::json(['type' => 'success', 'message' => 'Recorded patient\'s vitals successfully', 'data' => $this->getVitalsData($request['admission_id'])]);
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

    public function getVitalsData($admission_id)
    {
        try {
            return Vitals::where('admission_id', $admission_id)->latest()->limit(1)->get()->map(function ($item) {
                return
                    [
                        "id" => $item->id,
                        "height" => $item->height,
                        "weight" => $item->weight,
                        "bmi" => number_format($this->helper->calculateBMI($item->weight, $item->height), 2),
                        "bmi_status" => $this->helper->getBMIStatus($this->helper->calculateBMI($item->weight, $item->height)),
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
                        "date_time_recorded" => $item->date_recorded . " " . $item->time_recorded,
                        "timestamp" => $this->carbon->parse($item->created_at)->format('d/m/Y H:i A')
                    ];

            })->toArray();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function deleteVitals(Request $request)
    {
        \DB::beginTransaction();
        try {
            $request = $request->json()->all();
            $v = Vitals::find($request['id']);
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

    public function getAllInvestigations($visit_id)
    {
        try {
            $data = Investigations::where("visit", $visit_id)->get()->map(function ($item) {
                return
                    [
                        "id" => $item->id,
                        "visit_id" => $item->visit,
                        "type" => $item->type,
                        "procedure" => $item->procedures->name,
                        "quantity" => $item->quantity,
                        "price" => $item->price,
                        "discount" => $item->discount,
                        "amount" => $item->amount,
                        "user" => $item->doctors->profile->fullName,
                        "instructions" => $item->instructions,
                        "ordered" => $item->ordered,
                        "invoiced" => $item->invoiced,
                        "requested_on" => $this->carbon->parse($item->updated_at)->format('H:i A d/m/Y ')
                    ];

            })->toArray();
            return json_encode(['type' => 'success', 'data' => $data]);
        } catch (\Exception $e) {
            return json_encode(['type' => 'error', 'message' => 'An error occured. No investigations found. ' . $e->getMessage()]);
        }
    }

    public function getAllPrescriptions($admission_id, $type)
    {
        try {
            return
                $data = Prescription::where("admission_id", $admission_id)->where("type", $type)->where('status', 1)->orderBy("updated_at", "DESC")->get()->map(function ($item) {
                    return
                        [
                            "id" => $item->id,
                            "visit_id" => $item->visit,
                            "dose" => $item->dose,
                            "drug" => $item->drug,
                            "route" => $item->whereto,
                            "method" => $item->method,
                            "take" => $item->take,
                            "duration" => $item->duration,
                            "time_measure" => $item->time_measure,
                            "fr_du" => $item->take . "/" . $item->duration,
                            "allow_sub" => $item->sub,
                            "by" => $item->users->profile->fullName,
                            "status" => $item->status,
                            "prescribed_on" => $this->carbon->parse($item->updated_at)->format('H:i A d/m/Y ')

                        ];

                })->toArray();
            return json_encode(['type' => 'success', 'data' => $data]);
        } catch (\Exception $e) {
            return json_encode(['type' => 'error', 'message' => 'An error occured. No prescriptions found. ' . $e->getMessage()]);
        }
    }

    public function getDischargePrescriptions($admission_id){
        try {
            return
                $data = Prescription::where("admission_id", $admission_id)->where("for_discharge", 1)->orderBy("updated_at", "DESC")->get()->map(function ($item) {
                    return
                        [
                            "id"            => $item->id,
                            "visit_id"      => $item->visit,
                            "dose"          => $item->dose,
                            "drug"          => $item->drug,
                            "route"         => $item->whereto,
                            "method"        => $item->method,
                            "take"          => $item->take,
                            "duration"      => $item->duration,
                            "time_measure"  => $item->time_measure,
                            "fr_du"         => $item->take . "/" . $item->duration,
                            "allow_sub"     => $item->sub,
                            "by"            => $item->users->profile->fullName,
                            "status"        => $item->status,
                            "prescribed_on" => $this->carbon->parse($item->updated_at)->format('H:i A d/m/Y ')
                        ];
                })->toArray();
            return json_encode(['type' => 'success', 'data' => $data]);
        }catch (\Exception $e) {
            return json_encode(['type' => 'error', 'message' => 'An error occured. No prescriptions found. ' . $e->getMessage()]);
        }
    }

    public function cancelPrescription(Request $request)
    {
        \DB::beginTransaction();
        try {
            $request = $request->json()->all();
            $p = Prescription::find("id", $request['id']);
            $p->status = 1;
            if ($p) {
                \DB::commit();
                return Response::json(['type' => 'success', 'message' => 'Prescription canceled']);
            } else {
                \DB::rollback();
                return Response::json(['type' => 'error', 'message' => 'Could not cancel prescription']);
            }
        } catch (\Exception $e) {
            return Response::json(['type' => 'error', 'message' => 'An error occured. The prescription could not be canceled. ' . $e->getMessage()]);
        }
    }

    // public function getAllDiagnosis($admission_id, $id, $visit_id){
    // 	//
    // }

    public function getProcedures($admission_id, $visit_id)
    {
        \DB::beginTransaction();
        try {
            // $data =

        } catch (\Exception $e) {
            return Response::json(['type' => 'error', 'message' => 'An error occured. The procedures could not be retrieved. ' . $e->getMessage()]);
        }

    }

    public function getAllPerfomedProcedures($admission_id)
    {

    }

    public function getAllQueuedProcedures($admission_id)
    {

    }

    public function getNotes($admission_id, $type)
    {
        try {
            $data = Notes::where("admission_id", $admission_id)->where("type", $type)->orderBy("updated_at", "DESC")->get()->map(function ($item) {
                return
                    [
                        "id" => $item->id,
                        "admission_id" => $item->admission_id,
                        "visit_id" => $item->visit_id,
                        "notes" => substr($item->notes,0,20),
                        "name" => $item->users->profile->fullName,
                        "written_on" => $this->carbon->parse($item->created_at)->format('d/m/y H:i A')
                    ];
            })->toArray();
            return json_encode(['type' => 'success', 'data' => $data]);
        } catch (\Exception $e) {
            return json_encode(['type' => 'error', 'message' => 'An error occured. Could not retrieve notes. ' . $e->getMessage()]);
        }
    }

    public function getNote($id)
    {
        try {
            $data = Notes::where("id", $id)->limit(1)->get()->map(function ($item) {
                return
                    [
                        "id" => $item->id,
                        "admission_id" => $item->admission_id,
                        "visit_id" => $item->visit_id,
                        "notes" => $item->notes,
                        "name" => $item->users->profile->fullName,
                        "written_on" => $this->carbon->parse($item->created_at)->format('d/m/y H:i A')
                    ];
            })->toArray();
            return Response::json(['type' => 'success', 'data' => $data]);
        } catch (\Exception $e) {
            return Response::json(['type' => 'error', 'message' => 'An error occured. Could not retrieve notes. ' . $e->getMessage()]);
        }
    }

    public function getHeadInjuries($admission_id)
    {
        try {
            $data = HeadInjury::where("admission_id", $admission_id)->orderBy("updated_at", "DESC")->get()->map(function ($item) {
                return
                    [
                        "id" => $item->id,
                        "admission_id" => $item->admission_id,
                        "bp_systolic" => $item->bp_systolic,
                        "bp_diastolic" => $item->bp_diastolic,
                        "pulse" => $item->pulse,
                        "respiration" => $item->respiration,
                        "temperature" => $item->temperature,
                        "conscious_status" => unserialize($item->conscious_status),
                        "pupil_status" => unserialize($item->pupil_status),
                        "user" => $item->users->profile->fullName,
                        "recorded_on" => $this->carbon->parse($item->created_at)->format('d/m/y H:i A')
                    ];
            })->toArray();

            return json_encode(['type' => 'success', 'data' => $data]);

        } catch (\Exception $e) {
            return Response::json(['type' => 'error', 'message' => 'An error occured during fetching. ' . $e->getMessage()]);
        }
    }

    public function getFluidBalances($admission_id)
    {
        try {
            $fluidbalances = FluidBalance::where("admission_id", $admission_id)->orderBy("updated_at", "DESC")->get()->map(function ($item) {
                return
                    [
                        "id" => $item->id,
                        "intravenous_infusion_instructions"     => $item->intravenous_infusion,
                        "intake_intravenous"                    => unserialize($item->intake_intravenous),
                        "intake_alimentary"                     => unserialize($item->intake_alimentary),
                        "output"                                => unserialize($item->output),
                        "recorded_by"                           => $item->user->profile->fullName,
                        "recorded_on"                           => $item->time_recorded . " " . $this->carbon->parse($item->date_recorded)->format('d/m/Y')
                    ];
            })->toArray();

            $data = [];
            foreach($fluidbalances as $key => $fb){
                $data[] =
                    [
                        $fb['recorded_on'],
                        $fb['intake_intravenous']['type'],
                        $fb['intake_intravenous']['bottle'],
                        $fb['intake_intravenous']['infused'],
                        $fb['intake_alimentary']['type'],
                        $fb['intake_alimentary']['amount'],
                        $fb['output']['vomit'],
                        $fb['output']['stool'],
                        $fb['output']['ngast'],
                        $fb['output']['others'],
                        $fb['output']['urine_amount'],
                        $fb['output']['specific_gravidity']
                    ];
            }

            return  response()->json(['data' => $data]);

        } catch (\Exception $e) {
            return Response::json(['type' => 'error', 'message' => 'An error occured during fetching. ' . $e->getMessage()]);
        }
    }
	
    public function addFluidBalances(Request $request){
        \DB::beginTransaction();
        try{
            $request = $request->json()->all();
            $intake_intraveneous = [
                                    'type'      => $request['intravenous_type'], 
                                    'bottle'    => $request['bottle'], 
                                    'infused'   => $request['infused']
                                ];
            $intake_alimentary  = [
                                    'type'      => $request['alimentary_type'],
                                    'amount'    => $request['alimentary_amount']
                                ];
            $output             = [
                                    'vomit'                 => $request['vomit'],
                                    'stool'                 => $request['stool'],
                                    'ngast'                 => $request['ngast'],
                                    'others'                => $request['others'],
                                    'urine_amount'          => $request['urine_amount'],
                                    'specific_gravidity'    => $request['specific_gravidity']
                                ];
            $fb = new FluidBalance;
            $fb->admission_id         = $request['admission_id'];
            $fb->visit_id             = $request['visit_id'];
            $fb->intravenous_infusion = $request['intravenous_infusion'];
            $fb->other_instructions   = $request['other_instructions'];
            $fb->intake_intraveneous  = serialize($intake_intraveneous);
            $fb->intake_alimentary    = serialize($intake_alimentary);
            $fb->output               = serialize($output);
            $fb->user_id              = $request['user_id'];
            $fb->time_recorded        = $request['time_recorded'];
            $fb->date_recorded        = $request['date_recorded'];
            $fb->save();
            \DB::commit();
            return ($fb) ? Response::json(['type' => 'success', 'message' => 'Fluid Balance saved!']) : Response::json(['type' => 'error', 'message' => 'The fluid balance could not be saved']);
        }catch(\Exception $e){
            \DB::rollback();
            return Response::json(['type' => 'error', 'message' => 'Your fluid balance could not be saved. '. $e->getMessage()]);
        }
    }

    // public function getFluidBalanceData($admission_id){
    //     try{
    //         $data =  FluidBalance::where("admission_id", $admission_id)->get()->map(function($item){
    //             return 
    //             [
    //                 "id"                                    => $item->id,
    //                 "intravenous_infusion_instructions"     => $item->intravenous_infusion,
    //                 "intake_intravenous"                    => unserialize($item->intake_intravenous),
    //                 "intake_alimentary"                     => unserialize($item->intake_alimentary),
    //                 "output"                                => unserialize($item->output),
    //                 "recorded_by"                           => $item->user->profile->fullName,
    //                 "recorded_on"                           => $item->time_recorded . " " . $item->date_recorded
    //             ];
    //         })->toArray();
     
    //         return json_encode($data);
    //     }catch(\Exception $e){
    //         return $e->getMessage();
    //     }
    // }

    public function addNote(Request $request)
    {
        \DB::beginTransaction();
        try {
            $request = $request->json()->all();
            $n = Notes::create($request);
            \DB::commit();
            return ($n->id > 0) ? Response::json(['type' => 'success', 'message' => 'Notes saved!', 'data' => $this->getNoteData($n->id, $n->type)]) : Response::json(['type' => 'error', 'message' => 'Your note could not be saved']);
        } catch (\Exception $e) {
            \DB::rollback();
            return Response::json(['type' => 'error', 'message' => 'Your note could not be saved. ' . $e->getMessage()]);
        }
    }

    public function getNoteData($id)
    {
        try {
            $data = Notes::where("id", $id)->get()->map(function ($item) {
                return
                    [
                        "id" => $item->id,
                        "admission_id" => $item->admission_id,
                        "visit_id" => $item->visit_id,
                        "notes" => substr($item->notes,0,20).'...',
                        "name" => $item->users->profile->fullName,
                        "written_on" => $this->carbon->parse($item->created_at)->format('d/m/y H:i A')
                    ];
            })->toArray();
            return json_encode($data);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
	
    public function updateFluidBalances(Request $request){
        \DB::beginTransaction();
        try{
            $request = $request->json()->all();
            $fb = FluidBalance::find($request['id'])->first();
            $intake_intraveneous = [
                                    'type'      => $request['intravenous_type'], 
                                    'bottle'    => $request['bottle'], 
                                    'infused'   => $request['infused']
                                ];
            $intake_alimentary  = [
                                    'type'      => $request['alimentary_type'],
                                    'amount'    => $request['alimentary_amount']
                                ];
            $output             = [
                                    'vomit'                 => $request['vomit'],
                                    'stool'                 => $request['stool'],
                                    'ngast'                 => $request['ngast'],
                                    'others'                => $request['others'],
                                    'urine_amount'          => $request['urine_amount'],
                                    'specific_gravidity'    => $request['specific_gravidity']
                                ];
            $fb->admission_id         = $request['admission_id'];
            $fb->visit_id             = $request['visit_id'];
            $fb->intravenous_infusion = $request['intravenous_infusion'];
            $fb->other_instructions   = $request['other_instructions'];
            $fb->intake_intraveneous  = serialize($intake_intraveneous);
            $fb->intake_alimentary    = serialize($intake_alimentary);
            $fb->output               = serialize($output);
            $fb->user_id              = $request['user_id'];
            $fb->time_recorded        = $request['time_recorded'];
            $fb->date_recorded        = $request['date_recorded'];
            $fb->save();
            \DB::commit();
            return ($fb->id > 0) ? Response::json(['type' => 'success', 'message' => 'Fluid Balance updated!']) : Response::json(['type' => 'error', 'message' => 'Fluid Balance could not be updated']);
        }catch(\Exception $e){
            \DB::rollback();
            return Response::json(['type' => 'error', 'message' => 'The fluid balance could not be updated. '. $e->getMessage()]);
        }
    }

    public function deleteFluidBalances(Request $request){
        \DB::beginTransaction();
        try{
            $request = $request->json()->all();
            $fb = FluidBalance::find($request)->first();
            $fb->delete();
            \DB::commit();
            return ($fb->id > 0) ? Response::json(['type' => 'success', 'message' => 'Fluid deleted!']) : Response::json(['type' => 'error', 'message' => 'The fluid balance could not be deleted']);
        }catch(\Exception $e){
            \DB::rollback();
            return Response::json(['type' => 'error', 'message' => 'The fluid balance could not be deleted. '. $e->getMessage()]);
        }
    }    

	public function getBloodTransfusions($admission_id){
		try{
			//
		}catch(\Exception $e){
			return Response::json(['type' => 'error', 'message' => 'An error occured during fetching. '. $e->getMessage()]);
		}
	}

	
	public function updateNote(Request $request){
		try{
			$request = $request->json()->all();
			$n = Notes::find($request['id']);
			$n->notes = $request['notes'];
			$n->user = $request['user'];
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

    public function addInvestigations(Request $request)
    {
        try {
            $request = $request->json()->all();

            return $request;

        } catch (\Exception $e) {
            return Response::json(['type' => 'error', 'message' => 'An error occured. The investigation could not be added. ' . $e->getMessage()]);
        }

    }

    public function addBloodTransfusions(Request $request)
    {
        \DB::beginTransaction();
        try {

            $request = $request->json()->all();
            $b = new BloodTransfusion;
            $b->admission_id = $request['admission_id'];
            $b->visit_id = $request['visit_id'];
            $b->bp_systolic = $request['bp_systolic'];
            $b->bp_diastolic = $request['bp_diastolic'];
            $b->temperature = $request['temperature'];
            $b->respiration = $request['respiration'];
            $b->date_recorded = $request['date_recorded'];
            $b->time_recorded = $request['time_recorded'];
            $b->remarks = $request['remarks'];
            $b->user_id = $request['user_id'];
            $b->save();

            \DB::commit();

            if ($b) {
                return Response::json(['type' => 'success', 'message' => 'Blood Transfusion data saved!', 'data' => $this->getTransfusionData($request['admission_id'])]);
            } else {
                \DB::rollback();
                return Response::json(['type' => 'error', 'message' => 'An problem occured. The blood transfusion data could not be saved']);
            }

        } catch (\Exception $e) {
            \DB::rollback();
            return Response::json(['type' => 'error', 'message' => 'An error occured. The blood transfusion data could not be saved. ' . $e->getMessage()]);
        }
    }

    public function getTransfusionData($admission_id)
    {
        try {
            $data = BloodTransfusion::where("admission_id", $admission_id)->latest()->limit(1)->get()->map(function ($item) {
                return [
                    "id" => $item->id,
                    "temperature" => $item->temperature,
                    "bp" => $item->bp_systolic . "/" . $item->bp_diastolic,
                    "respiration" => $item->respiration,
                    "remarks" => substr($item->remarks, 0, 20),
                    "date_time" => $item->date_recorded . " " . $item->time_recorded
                ];
            })->toArray();

            return json_encode($data);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateBloodTransfusions(Request $request)
    {
        \DB::beginTransaction();
        try {
            $request = $request->json()->all();
            $b = BloodTransfusion::update($request);
            if ($b) {
                \DB::commit();
                return Response::json(['type' => 'success', 'message' => 'Blood Transfusion data updated!']);
            } else {
                \DB::rollback();
                return Response::json(['type' => 'error', 'message' => 'An problem occured. The blood transfusion data could not be updated']);
            }

        } catch (\Exception $e) {
            \DB::rollback();
            return Response::json(['type' => 'error', 'message' => 'An error occured. The blood transfusion data could not be updated. ' . $e->getMessage()]);
        }
    }

    public function deleteBloodTransfusions(Request $request)
    {
        \DB::beginTransaction();
        try {
            $request = $request->json()->all();
            $b = BloodTransfusion::find($request['id']);
            $b->delete();
            if ($b) {
                \DB::commit();
                return Response::json(['type' => 'success', 'message' => 'Blood Transfusion data deleted!']);
            } else {
                \DB::rollback();
                return Response::json(['type' => 'error', 'message' => 'An problem occured. The blood transfusion data could not be deleted']);
            }

        } catch (\Exception $e) {
            \DB::rollback();
            return Response::json(['type' => 'error', 'message' => 'An error occured. The blood transfusion data could not be saved. ' . $e->getMessage()]);
        }
    }

    public function getDrug($term)
    {
        try {
            $found = collect();
            $ret = [];

            if (!empty($term)) {
                $found = InventoryProducts::with(['prices' => function ($query) {

                }])->with(['stocks' => function ($query) {

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
        } catch (\Exception $e) {
            return Response::json(['type' => 'error', 'message' => 'An error occured. The drug could not be found. ' . $e->getMessage()]);
        }
    }

    public function addPrescription(Request $request)
    {
        \DB::beginTransaction();
        try {
            $request = $request->json()->all();
            $p = Prescription::create($request);
            // Add to Prescription Queue
            $this->checkInAt($request['visit'], 'pharmacy');
            \DB::commit();
            if ($p) {
                return Response::json(['type' => 'success', 'message' => 'The prescription has been added. The Pharmacy has been notified to dispense it for it to be administered', 'data' => $this->getPrescriptionData($request['visit'])]);
            } else {
                \DB::rollback();
                return Response::json(['type' => 'error', 'message' => 'An error occured while saving. Please try again!']);
            }
        } catch (\Exception $e) {
            return Response::json(['type' => 'error', 'message' => 'An error occured. The prescription could not be added. ' . $e->getMessage()]);
        }
    }

    public function addDischargePrescription(Request $request)
    {
        \DB::beginTransaction();
        try {
            $request = $request->json()->all();
            $p = Prescription::create($request);
            // Add to Prescription Queue
            $this->checkInAt($request['visit'], 'pharmacy');
            \DB::commit();
            if ($p) {
                return Response::json(['type' => 'success', 'message' => 'The prescription has been added. The Pharmacy has been notified to dispense it for it to be administered', 'data' => $this->getPrescriptionData($request['visit'])]);
            } else {
                \DB::rollback();
                return Response::json(['type' => 'error', 'message' => 'An error occured while saving. Please try again!']);
            }
        } catch (\Exception $e) {
            return Response::json(['type' => 'error', 'message' => 'An error occured. The prescription could not be added. ' . $e->getMessage()]);
        }
    }

    public function getPrescriptionData($visit_id)
    {
        try {
            return Prescription::where("visit", $visit_id)->latest()->limit(1)->get()->map(function ($item) {
                return
                    [
                        "id" => $item->id,
                        "dose" => $item->dose,
                        "drug" => $item->drugs->name,
                        "prescribed_by" => $item->users->profile->fullName,
                        "prescribed_on" => $this->carbon->parse($item->updated_at)->format('H:i A d/m/Y ')
                    ];
            });
        } catch (\Exception $e) {
            return Response::json(['type' => 'error', 'message' => 'An error occured. The prescription could not be added. ' . $e->getMessage()]);
        }
    }

    public function postBp(Request $request)
    {
        $result = BloodPressure::create($request->all());
        return response()->json($result);
    }

    /**
     * Build an index of items dynamically
     * @param Request $request
     * @return array
     */
    private function _get_selected_stack(Request $request)
    {
        $stack = [];
        $this->input = \request()->all();
        foreach ($this->input as $key => $one) {
            if (starts_with($key, 'item')) {
                $stack[] = substr($key, 4);
            }
        }
        return $stack;
    }

    public function saveConsumables(Request $request)
    {
        \DB::transaction(function () use ($request) {
            foreach ($this->_get_selected_stack($request) as $consumable) {
                InpatientConsumable::create([
                    'type' => $this->input['type' . $consumable],
                    'visit' => $request->visit,
                    'product_id' => $consumable,
                    'quantity' => $this->input['quantity' . $consumable],
                    'price' => $this->input['price' . $consumable],
                    'discount' => $this->input['discount' . $consumable],
                    'amount' => $this->input['amount' . $consumable],
                    'instructions' => empty($this->input['instructions' . $consumable]) ? null : $this->input['instructions' . $consumable],
                    'user' => $request->user()->id,
                    'ordered' => true
                ]);
//                $this->check_in_at($this->input['type' . $consumable]);
            }
        });
    }

    public function postTemperature(Request $request)
    {
        $input = $request->all();
        foreach ($input as $key => $item) {
            if (empty($item)) {
                unset($input[$key]);
            }
        }
        unset($input['_token']);
        $result = Temperature::create($input);
        return response()->json($result);
    }

    public function getTemperature(Request $request)
    {
        $result = Temperature::all()->last();
        return response()->json(['temperature' => random_int(0, 300)]);
    }

    public function getDoneInvestigations($visit)
    {
        /** @var Investigations[] $data */
        $data = get_inpatient_investigations($visit);
        $return = [];
        foreach ($data as $key => $item) {
            if ($item->has_result)
                $link = '<a href="' . route('evaluation . view_result', $item->visit) . '"
                                               class="btn btn-xs btn-success" target="_blank">
                                                <i class="fa fa-external-link"></i> View Result
            </a>';
            else
                $link = '<span class="text-warning" ><i class="fa fa-warning" ></i > Pending</span>';

            $return[] = [
                str_limit($item->procedures->name, 20, '...'),
                ucfirst(substr($item->type, 1 + strpos($item->type, '-'))),
                $item->price, $item->quantity, $item->discount,
                $item->amount > 0 ? $item->amount : $item->price,
                $item->created_at->format('d/m/Y h:i a'),
                payment_label($item->is_paid),
                $link,
            ];
        }
        return response()->json(['data' => $return]);
    }

    public function getDoneConsumables($visit)
    {
        /** @var InpatientConsumable[] $data */
        $data = InpatientConsumable::whereVisit($visit)->get();
        $return = [];
        foreach ($data as $item) {
            $return[] = [
                str_limit($item->product->name, 20, '...'),
                ucfirst(substr($item->type, 1 + strpos($item->type, '.'))),
                $item->price, $item->quantity, $item->discount,
                $item->amount > 0 ? $item->amount : $item->price,
                $item->created_at->format('d/m/Y h:i a'),
                payment_label($item->is_paid)
            ];
        }
        return response()->json(['data' => $return]);
    }

    public function getDoneProcedures($visit)
    {
        /** @var Investigations[] $data */
        $data = get_inpatient_investigations($visit, 'procedure');
        $return = [];
        foreach ($data as $key => $item) {
            if ($item->has_result)
                $link = '<a href="' . route('evaluation . view_result', $item->visit) . '"
                                               class="btn btn-xs btn-success" target="_blank">
                                                <i class="fa fa-external-link"></i> View Result
            </a>';
            else
                $link = '<span class="text-warning" ><i class="fa fa-warning" ></i > Pending</span>';

            $return[] = [
                str_limit($item->procedures->name, 20, '...'),
                ucfirst(substr($item->type, 1 + strpos($item->type, '-'))),
                $item->price, $item->quantity, $item->discount,
                $item->amount > 0 ? $item->amount : $item->price,
                $item->created_at->format('d/m/Y h:i a'),
                payment_label($item->is_paid),
                $link,
//                $item->
            ];
        }
        return response()->json(['data' => $return]);
    }

    private function checkInAt($visit_id, $place)
    {
        $department = $place;
        $destination = NULL;
        if (intval($place) > 0) {
            $destination = (int)$department;
            $department = 'doctor';
        }
        $destinations = VisitDestinations::firstOrNew(['visit' => $visit_id, 'department' => ucwords($department)]);
        $destinations->destination = $destination;
        $destinations->user = \Auth::user()->id;
        $destinations->save();
    }

    public function updatePrescription(Request $request, $id)
    {
        \DB::beginTransaction();
        try {
            $request = $request->json()->all();
            $p = Prescription::find($id);
            $p->drug = $request['drug'];
            $p->whereto = $request['whereto'];
            $p->method = $request['method'];
            $p->duration = $request['duration'];
            $p->allow_substitution = $request['allow_substitution'];
            $p->time_measure = $request['time_measure'];
            $p->save();

            if ($p) {
                \DB::commit();
                return Response::json(['type' => 'success', 'message' => 'The prescription has been updated. ']);
            } else {
                \DB::rollback();
                return Response::json(['type' => 'error', 'message' => 'An error occured. The prescription could not be updated.']);
            }
        } catch (\Exception $e) {
            return Response::json(['type' => 'error', 'message' => 'An error occured. The prescription could not be added. ' . $e->getMessage()]);
        }
    }

    public function deletePrescription(Request $request)
    {
        \DB::beginTransaction();
        try {
            $request = $request->json()->all();
            $p = Prescription::where("id", $request['id'])->first();
            $prescription = $this->getPrescription($request['id']);
            $c = new CanceledPrescriptions;
            $c->admission_id = $request['admission_id'];
            $c->visit_id = $request['visit_id'];
            $c->reason = $request['reason'];
            $c->drug = $prescription->drug;
            $c->take = $prescription->take;
            $c->whereto = $prescription->whereto;
            $c->method = $prescription->method;
            $c->duration = $prescription->duration;
            $c->allow_substitution = $prescription->allow_substitution;
            $c->time_measure = $prescription->time_measure;
            $c->user_id = $request['user_id'];

            $c->save();
            $p->delete();

            if ($p && $c) {
                \DB::commit();
                return Response::json(['type' => 'success', 'message' => 'Prescription canceled successfully']);
            } else {
                \DB::rollback();
                return Response::json(['type' => 'error', 'message' => 'Could not cancel prescription']);
            }
        } catch (\Exception $e) {
            return Response::json(['type' => 'error', 'message' => 'An error occured. The prescription could not be canceled. ' . $e->getMessage()]);
        }
    }

    public function stopPrescription(Request $request)
    {
        \DB::beginTransaction();
        try {
            $request = $request->json()->all();
            $p = Prescription::where("id", $request['id']);
            $p->stop_reason = $request['reason'];
            $p->stopped = 1;
            $p->save();
            if ($p) {
                \DB::commit();
                return Response::json(['type' => 'success', 'message' => 'Prescription stopped successfully']);
            } else {
                \DB::rollback();
                return Response::json(['type' => 'error', 'message' => 'Could not stop prescription']);
            }
        } catch (\Exception $e) {
            return Response::json(['type' => 'error', 'message' => 'An error occured. The prescription could not be stopped. ' . $e->getMessage()]);
        }
    }

    private function getPrescription($id)
    {
        try {
            return Prescription::find($id)->first(['drug', 'take', 'whereto', 'method', 'duration', 'allow_substitution', 'time_measure']);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getAdministrationLogs($prescription_id)
    {
        try {
            $data = Administration::where("prescription_id", $prescription_id)->orderBy("updated_at", "DESC")->get()->map(function ($item) {
                return
                    [
                        "id" => $item->id,
                        "dose" => $item->prescription->dose,
                        "recorded_by" => $item->users->profile->fullName,
                        "recorded_on" => $item->time . " " . $this->carbon->parse($item->created_at)->format('d/m/y')
                    ];
            })->toArray();

            return json_encode(['type' => 'success', 'data' => $data]);

        } catch (\Exception $e) {
            return Response::json(['type' => 'error', 'message' => 'An error occured. The prescription administration logs could not be retrieved. ' . $e->getMessage()]);
        }

    }

    public function administerPrescription(Request $request)
    {
        try {
            $request = $request->json()->all();
            $a = new Administration;
            $a->admission_id = $request['admission_id'];
            $a->prescription_id = $request['prescription_id'];
            $a->visit_id = $request['visit_id'];
            $a->time = $request['time'];
            $a->user = $request['user'];
            $a->save();

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
            $a->time = $request['time'];
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
            $data = NursingCarePlan::where("admission_id", $id)->get()->map(function ($item) {
                return [
                    "id"                    => $item->id,
                    "diagnosis"             => $item->diagnosis,
                    "expected_outcome"      => $item->expected_outcome,
                    "intervention"          => $item->intervention,
                    "recorded_by"           => $item->user->profile->fullName,
                    "reasons"               => $item->reasons,
                    "date_time_recorded"    => $item->date_recorded . " " . $item->time_recorded
                ];
            })->toArray();

            return ($data) ? Response::json(['type' => 'success', 'data' => $data]) : Response::json(['type' => 'error', 'message' => 'The nursing care plans could not be retrieved']);
        } catch (\Exception $e) {
            return Response::json(['type' => 'error', 'message' => 'An error occured. The nursing care plans could not be retrieved. ' . $e->getMessage()]);
        }
    }

    public function getNursingCarePlan($id)
    {
        try {
            $data = NursingCarePlan::where("id",$id)->get()->map(function ($item) {
                return [
                    "id"                    => $item->id,
                    "diagnosis"             => $item->diagnosis,
                    "expected_outcome"      => $item->expected_outcome,
                    "intervention"          => $item->intervention,
                    "reasons"               => $item->reasons,
                    "evaluation"            => $item->evaluation, 
                    "recorded_by"           => $item->user->profile->fullName,
                    "date_time_recorded"    => $item->date_recorded . " " . $item->time_recorded
                ];
            })->toArray();

            return ($data) ? Response::json(['type' => 'success', 'data' => $data]) : Response::json(['type' => 'error', 'message' => 'The nursing care plan could not be retrieved']);
        } catch (\Exception $e) {
            return Response::json(['type' => 'error', 'message' => 'An error occured. The nursing care plan could not be retrieved. ' . $e->getMessage()]);
        }
    }

    public function addNursingCarePlan(Request $request)
    {
        \DB::beginTransaction();
        try {
            $request = $request->json()->all();
            $n = new NursingCarePlan;
            $n->visit_id          = $request['visit_id'];
            $n->admission_id      = $request['admission_id'];
            $n->diagnosis         = $request['diagnosis'];
            $n->expected_outcome  = $request['expected_outcome'];
            $n->intervention      = $request['intervention'];
            $n->reasons           = $request['reasons'];
            $n->evaluation        = $request['evaluation'];
            $n->date_recorded     = $request['date_recorded'];
            $n->time_recorded     = $request['time_recorded'];
            $n->user_id           = $request['user_id'];
            $n->save();
            
            \DB::commit();
            return ($n) ? Response::json(['type' => 'success', 'message' => 'The nursing care plan has been saved!', 'data' => $this->getCarePlanData($request['admission_id'])]) : Response::json(['type' => 'error', 'message' => 'The nursing care plan could not be saved']);
        } catch (\Exception $e) {
            \DB::rollback();
            return Response::json(['type' => 'error', 'message' => 'An error occured. The nursing care plan could not be saved. ' . $e->getMessage()]);
        }
    }

    public function getCarePlanData($admission_id)
    {
        try {
            $n = NursingCarePlan::where("admission_id", $admission_id)->latest()->limit(1)->get()->map(function ($item) {
                return
                    [
                        "id"                    => $item->id,
                        "diagnosis"             => $item->diagnosis,
                        "expected_outcome"      => $item->expected_outcome,
                        "intervention"          => $item->intervention,
                        "recorded_by"           => $item->recorded_by,
                        "date_time_recorded"    => $item->date_recorded . " " . $item->time_recorded
                    ];
            })->toArray();

            return json_encode($n);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateNursingCarePlan(Request $request)
    {
        \DB::beginTransaction();
        try {
            $request = $request->json()->all();
            $n = NursingCarePlan::update($request);
            \DB::commit();
            return ($n) ? Response::json(['type' => 'success', 'message' => 'The nursing care plan has been updated!']) : Response::json(['type' => 'error', 'message' => 'The nursing care plan could not be updated']);
        } catch (\Exception $e) {
            \DB::rollback();
            return Response::json(['type' => 'error', 'message' => 'An error occured. The nursing care plan could not be updated. ' . $e->getMessage()]);
        }
    }

    public function deleteNursingCarePlan(Request $request)
    {
        \DB::beginTransaction();
        try {
            $request = $request->json()->all();
            $n = NursingCarePlan::find($request['id']);
            $n->delete();
            \DB::commit();
            return ($n) ? Response::json(['type' => 'success', 'message' => 'The nursing care plan has been deleted!']) : Response::json(['type' => 'error', 'message' => 'The nursing care plan could not be deleted']);
        } catch (\Exception $e) {
            \DB::rollback();
            return Response::json(['type' => 'error', 'message' => 'An error occured. The nursing care plan could not be deleted. ' . $e->getMessage()]);
        }
    }

    public function requestDischarge(Request $request){
        \DB::beginTransaction();
        try {
            $request = $request->json()->all();

            //add a record to request discharge table
            $r = new RequestDischarge;
            $r->doctor_id     = $request['doctor_id'];
            $r->admission_id  = $request['admission_id'];
            $r->visit_id      = $request['visit_id'];
            $r->reason        = $request['reason'];
            $r->status        = 'unconfirmed';
            $r->save();

            \DB::commit();
            if($r){
                return Response::json(['type' => 'success', 'message' => 'Discharge requested successfully']);
            }else{
                \DB::rollback();
                return Response::json(['type' => 'error', 'message' => 'An error occured. The discharge request could not be completed. ' . $e->getMessage()]);
            }
        }catch (\Exception $e) {
            \DB::rollback();
            return Response::json(['type' => 'error', 'message' => 'An error occured. The discharge request could not be completed. ' . $e->getMessage()]);
        }
    }

    public function discharge(Request $request){
        \DB::beginTransaction();
        try {
            $request = $request->json()->all();

            //the discharge isfor
            if ($request['type'] != 'case') {
                $request['dateofdeath'] = null;
                $request['timeofdeath'] = null;
            }

            // Check the pending reccurrent charges.
            // the ward's charges
            $wardCharges = 0; $recuCharges = 0;
            $wards = WardAssigned::where('visit_id', $request['visit_id'])->get();

            // foreach ($wards as $ward) {
            //     $wardCharges += $ward->price * $this->carbon->now()->diffInDays($ward->created_at);

            //     //subscribed reccurrent charges
            //     $rcnt = RecurrentCharge::where('visit_id', $request['visit_id'])->where('status', 'unpaid')->get();

            //     $recuCharges = $rcnt->sum(function($recurrent){
            //         return $sum += NursingCharge::find($recurrent->recurrent_charge_id)->cost * $this->carbon->now()->diffInDays($ward->created_at);
            //     });
            // }

             foreach ($wards as $ward) {
                $wardCharges += ($this->carbon->now() != null) ? ($ward->price * ($this->carbon->parse($this->carbon->now())->diffInDays($ward->created_at) )) : $ward->price * $this->carbon->now()->diffInDays($ward->created_at);
                //subscribed reccurrent charges
                foreach (RecurrentCharge::where('visit_id', $request['visit_id'])->where('status', 'unpaid')->get() as $recurrent) {
                    //nursing charges times no. of days..
                    $recuCharges +=  ($this->carbon->now() != null) ? NursingCharge::find($recurrent->recurrent_charge_id)->cost * $this->carbon->parse($this->carbon->now())->diffInDays($ward->created_at) : NursingCharge::find($recurrent->recurrent_charge_id)->cost;
                }
            }

            // foreach ($rcnt as $recurrent) {
            //     //nursing charges times no. of days..
            //     $recuCharges += NursingCharge::find($recurrent->recurrent_charge_id)->first()->cost * date_diff($this->carbon->now(),$ward->created_at);
            // }

            $totalCharges = $wardCharges + $recuCharges;

            //check patient account balance..
            $visit = Visit::find($request['visit_id'])->first();
            $acc = PatientAccount::where("patient_id", $visit->patient)->first();
            $acc_balance = 0;

            if ($acc) { $acc_balance = $acc->balance; }
            $visit = Visit::find($request['visit_id']);
            $acc = PatientAccount::firstOrNew(['patient'=>$visit->patient]);
            $acc_balance = $acc->balance;

            if ($totalCharges > $acc_balance) {
                $message = 'You have a pending charges of Kshs.'
                    . number_format($totalCharges) . '. Your account balance is Kshs. '
                    . number_format($acc_balance) . '. Please deposit Kshs.'
                    . number_format(($totalCharges - $acc_balance)) . ' to complete the discharge process.';
               $message2 = 'You have pending reccurrent charges. Please make the payment to proceed with the discharge';
                return Response::json(['type' => 'error', 'message' => $message.'\n'.$message2]);
            }

            //charge the recurrent charges from the patient acc.
            $acc->balance = $acc->balance - $totalCharges;
            $acc->save();

            Discharge::create([
                'visit_id'                  => $request['visit_id'],
                'admission_id'              => $request['admission_id'],
                'doctor_id'                 => $request['doctor_id'],
                'case_notes'                => $request['case_notes'],
                'principal_diagnosis'       => $request['principal_diagnosis'],
                'other_diagnosis'           => $request['other_diagnosis'],
                'admission_complaints'      => $request['complaints'],
                'investigations_courses'    => $request['investigations_courses'],
                'discharge_condition'       => $request['discharge_condition'],
                'dateofdeath'               => $request['dateofdeath'],
                'timeofdeath'               => $request['timeofdeath'],
                'type'                      => $request['type'],
                'to_come_again'             => $request['to_come_again']
            ]);

            //release the bed for reassignment.
            $admission = Admission::where('visit_id', $request['visit_id'])->first();
            $bed = Bed::where("visit_id", $admission->bed_id)->first();
            $bed->status = 'available';
            $bed->save();

            //record these charges to the patient
            //remove the discharge request.

          
            // Change admission status
            $admission->is_discharged = 1;
            $admission->save();

            // Change ward status
             foreach ($wards as $ward) {
                $ward->discharged_at = $this->carbon->now();
                $ward->status = 'unoccupied';
                $ward->save();
            }  

            // Remove Discharge request
            $request_disharge = RequestDischarge::where('visit_id', $request['visit_id'])->first();
            $request_disharge->delete();

            \DB::commit();
            return Response::json(['type' => 'success', 'message' => 'Patient has been discharged!']);
        }catch (\Exception $e) {
            \DB::rollback();
            return Response::json(['type' => 'error', 'message' => 'An error occured. The discharge could not be completed. ' . $e->getMessage()]);
        }
    }

}