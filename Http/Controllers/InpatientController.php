<?php

namespace Ignite\Inpatient\Http\Controllers;

use Carbon\Carbon;
use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Evaluation\Entities\Investigations;
use Ignite\Evaluation\Entities\Prescriptions;
use Ignite\Evaluation\Entities\RecurrentCharge;
use Ignite\Evaluation\Entities\VisitDestinations;
use Ignite\Evaluation\Repositories\EvaluationRepository;
use Ignite\Inpatient\Entities\Admission;
use Ignite\Inpatient\Entities\Administration;
use Ignite\Inpatient\Entities\Bed;
use Ignite\Inpatient\Entities\BedPosition;
use Ignite\Inpatient\Entities\BloodPressure;
use Ignite\Inpatient\Entities\BloodTransfusion;
use Ignite\Inpatient\Entities\Deposit;
use Ignite\Inpatient\Entities\Discharge;
use Ignite\Inpatient\Entities\DischargeNote;
use Ignite\Inpatient\Entities\FluidBalance;
use Ignite\Inpatient\Entities\Notes;
use Ignite\Inpatient\Entities\NursingCarePlan;
use Ignite\Inpatient\Entities\NursingCharge;
//use Ignite\Inpatient\Entities\PatientAccount;
use Ignite\Finance\Entities\PatientAccount;
use Ignite\Inpatient\Entities\RequestAdmission;
use Ignite\Inpatient\Entities\RequestDischarge;
use Ignite\Inpatient\Entities\Temperature;
use Ignite\Inpatient\Entities\Visit;
use Ignite\Inpatient\Entities\Vitals;
use Ignite\Inpatient\Entities\Ward;
use Ignite\Inpatient\Entities\WardAssigned;
use Ignite\Inpatient\Helpers\InpatientHelpers;
use Ignite\Inpatient\Entities\InpatientConsumable;
use Ignite\Reception\Entities\Patients;
use Ignite\Users\Entities\Roles;
use Ignite\Users\Entities\User;
use Ignite\Users\Entities\UserRoles;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Validator;
use Dompdf\Dompdf;

class InpatientController extends AdminBaseController
{
    private $request_admission;
    private $roles;
    private $user_roles;
    private $user;
    /**
     * @var Patients
     */
    private $patients;
    /**
     * @var Visit
     */
    private $visit;
    private $wards;
    private $beds;

    protected $evaluation;
    private $helper;

    /**
     * InpatientController constructor.
     * @param InpatientHelpers $helper
     * @param Carbon $carbon
     * @param Patients $patients
     * @param RequestAdmission $request_admission
     * @param Roles $roles
     * @param User $user
     * @param UserRoles $user_roles
     * @param Visit $visit
     * @param EvaluationRepository $evaluation
     */
    public function __construct(InpatientHelpers $helper, Carbon $carbon, Patients $patients, RequestAdmission $request_admission, Roles $roles, User $user, UserRoles $user_roles, Visit $visit, EvaluationRepository $evaluation)
    {
        parent::__construct();
        $this->_require_assets();

        $this->helper = $helper;
        $this->carbon = $carbon;
        $this->carbon->tz = new \DateTimeZone('Africa/Nairobi');
        $this->request_admission = $request_admission;
        $this->roles = $roles;
        $this->user_roles = $user_roles;
        $this->user = $user;
        $this->patients = $patients;
        $this->visit = $visit;
        $this->evaluation = $evaluation;
    }

    public function orderEvaluation($type)
    {
        if ($this->evaluation->order_evaluation($type)) {
            flash()->success('Test ordered for ' . $type);
            return Response::json(['type' => 'success', 'message' => 'Test ordered for ' . $type]);
        } else {
            flash('Something wasn\'t right', 'danger');
            return Response::json(['type' => 'error', 'message' => 'Could not order test for ' . $type]);
        }
        return back();
    }

    private function _require_assets()
    {

        $css_assets = [
            'vertical-tabs.css' => m_asset('inpatient:css/vertical-tabs.css'),
            'jquery.timepicker' => m_asset('inpatient:css/jquery.timepicker.css'),
            'summernote.css' => m_asset('inpatient:css/summernote.css')
        ];

        $js_assets = [
            'doctor-investigations.js' => m_asset('inpatient:js/doctor-investigations.js'),
            'doctor-procedures.js' => m_asset('inpatient:js/doctor-procedures.js'),
            'doctor-consumables.js' => m_asset('inpatient:js/consumables.js'),
            'inpatient-scripts.js' => m_asset('inpatient:js/inpatient-scripts.js'),
            'summernote.js' => m_asset('inpatient:js/summernote.js'),
            'jquery.timepicker.min.js' => m_asset('inpatient:js/jquery.timepicker.min.js'),
            'prescriptions.js' => m_asset('inpatient:js/inpatient/prescriptions.js'),
            'canvas-to-blob.min.js' => m_asset('inpatient:js/jpeg_camera/canvas-to-blob.min.js'),
            'jpeg_camera_with_dependencies.min.js' => m_asset('inpatient:js/jpeg_camera/jpeg_camera_with_dependencies.min.js')

        ];

        foreach ($css_assets as $key => $asset) {
            $this->assetManager->addAssets([$key => $asset]);
            $this->assetPipeline->requireCss($key);
        }

        foreach ($js_assets as $key => $asset) {
            $this->assetManager->addAssets([$key => $asset]);
            $this->assetPipeline->requireJs($key);
        }
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $patients = $this->patients->all();
        return view('inpatient::index', ['patients' => $patients]);
    }

    public function awaiting()
    {
        $patientIds = $this->request_admission->where('id', '!=', null)->get(['patient_id'])->toArray();
        $patients = $this->request_admission->all();
        return view('inpatient::admission.admitAwaiting', ['patientIds' => $patientIds, 'patients' => $patients]);
    }

    public function requestAdmission(Request $request)
    {
        if (RequestAdmission::find($request->patient_id) == null) {
            RequestAdmission::create($request->toArray());
            \Session::flash('success', 'Admission request successful');
            return back()->with('success', 'Admission request successful');
        } else {
            return back()->with('error', 'The patient has already requested admission');
        }
    }

    public function cancel($id)
    {
        $admit_r = RequestAdmission::find($id);
        $admit_r->delete();
        return back()->with('success', 'Successfully canceled admission request');
    }

    public function admitWalkInPatient($id)
    {
        try {
            $doctor_rule = Roles::where('name', 'Doctor')->first();
            $doctor_ids = UserRoles::where('role_id', $doctor_rule->id)
                ->get(['user_id'])
                ->toArray();

            $doctors = User::findMany($doctor_ids);

            $patient = Patients::find($id);
            $wards = Ward::all();
            $beds = Bed::all();
            $bedpositions = BedPosition::all();
            $deposits = Deposit::all();
            $admissions = NursingCharge::all();
            return view('inpatient::admission.admit_form', compact('doctors', 'patient', 'wards', 'deposits', 'beds', 'bedpositions', 'admissions'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back()->with('error', 'An error occured!');
        }
    }

    public function admitPatientForm($id, $visit_id)
    {
        try {
            $doctor_rule = Roles::where('name', 'Doctor')->first();
            $doctor_ids = UserRoles::where('role_id', $doctor_rule->id)->get(['user_id'])->toArray();
            $doctors = User::findMany($doctor_ids);

            $patient = Patients::find($id);
            $visit = Visit::find($visit_id);
            $wards = Ward::all();
            $beds = Bed::all();
            $bedpositions = BedPosition::all();
            $deposits = Deposit::all();
            $request_id = RequestAdmission::where('visit_id', $visit_id)->first()->id;
            $admissions = NursingCharge::all();
            return view('inpatient::admission.admit_form', compact('doctors', 'patient', 'wards', 'deposits', 'visit', 'beds', 'bedpositions', 'request_id', 'admissions'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back()->with('error', 'An error occured!');
        }
    }

    public function admit(Request $request)
    {
        \DB::beginTransaction();
        try {
            $admitted = Admission::where("visit_id", $request->visit_id)->where("is_discharged", 1)->get();

            if (count($admitted) > 0) {
                return redirect("/inpatient/admit")->with('error', "Patient already admitted");
            }

            $visit = Visit::where("patient", $request->patient_id)->first();
            $request->visit_id = ($visit != null) ? $visit->id : $this->checkInPatient($request);

            if ($request->admission_doctor == 'other') {
                $request['external_doctor'] = $request->external_doc;
                $request['doctor_id'] = null;
            } else {
                $request['external_doctor'] = null;
                $request['doctor_id'] = $request->admission_doctor;
            }
            /*********************************** Apply charges  *************************************/

            // Find or create the patient account
            // $account = PatientAccount::where('patient', $request->patient_id)->first();
            $account = PatientAccount::firstOrNew(['patient' => $request->patient_id]);
            $account_balance = $account->balance;

            // Get Intial admission cost from ward and deposit charges
            $ward = Ward::find($request->ward_id)->first();
            $ward_cost = $ward->cost;
            $deposit = Deposit::find($request->deposit)->first();
            $deposit_amount = $deposit->cost;
            $cost = $ward_cost + $deposit_amount;

            // Update patient balance
            // $acc = PatientAccount::firstOrNew(['patient'=>$request->patient_id]);
            // $balance = $acc->balance - $cost;
            // $acc->balance = $balance;
            // $acc->save();

            // if ($request->payment_mode == 'cash') {

            //     PatientAccount::create([
            //         'debit' => $deposit_amount,
            //         'credit' => 0.00,
            //         'details' => 'Charged for ' . $deposit->name,
            //         'reference' => 'deposit_charge_' . str_random(5),
            //         'patient' => $request->patient_id
            //     ]);

            //     // debit the patient account
            //     if($acc != null){
            //         $acc->update(['balance' => $acc->balance - $cost]);
            //     }
            // }

            $adm_request = (isset($request->visit_id)) ? RequestAdmission::whereRaw("patient_id = '" . $request->patient_id . "' AND visit_id = '" . $request->visit_id . "'")->first() : RequestAdmission::where("patient_id", $request->patient_id)->first();

            $request->reason = (count($adm_request) > 0) ? $adm_request->reason : null;

            // Let's admit our guy
            $a = new Admission;
            $a->patient_id = $request->patient_id;
            $a->doctor_id = $request->doctor_id;
            $a->ward_id = $request->ward_id;
            $a->bed_id = $request->bed_id;
            $a->bedposition_id = $request->bedposition_id;
            $a->cost = $cost;
            $a->reason = $request->reason;
            $a->external_doctor = $request->external_doctor;
            $a->visit_id = $request->visit_id;
            $a->save();

            //the bed should change status to occupied
            if (count(BedPosition::where("id", $request->bedposition_id)->where("ward_id", $request->ward_id)->first()) > 0) {
                $bed = BedPosition::where("id", $request->bedposition_id)->where("ward_id", $request->ward_id)->first();
                if ($bed->status == 'occupied') {
                    return back()->with('error', 'That bed is already occupied!');
                } else {
                    $bed->update(['status' => 'occupied']);
                }
            }

            if (count($adm_request) > 0) {
                //remove this admission request
                $adm_request->delete();
            }

            $admission = $a->where("patient_id", $request->patient_id)->where("visit_id", $request->visit_id)->first();

            // Add recurrent charges such as admission and nursing charges etc that are recurrent if specified

            if ($request->has('recurrent_charges')) {
                // $newbalance = $acc->balance;

                foreach ($request->recurrent_charges as $rc) {
                    // Find specific charge 
                    $nc = NursingCharge::where("id", $rc)->first();
                    // Add to recurrent charges table
                    $r_charges = new RecurrentCharge;
                    $r_charges->admission_id = $admission->id;
                    $r_charges->visit_id = $request->visit_id;
                    $r_charges->recurrent_charge_id = $nc->id;
                    $r_charges->save();

                    $newbalance += $nc->cost;
                }

                // Update our balance to reflect these charges
                // $acc->balance = $newbalance;
                // $acc->save();

                // Update Admission cost info. to reflect these charges
                $admission->cost = $newbalance;
                $admission->save();
            }

            $w = new WardAssigned;
            $w->admission_id = $admission->id;
            $w->visit_id = $request->visit_id;
            $w->ward_id = $request->ward_id;
            $w->price = $ward_cost;
            $w->admitted_at = $admission->created_at;
            $w->status = "occupied";
            $w->save();

            \DB::commit();
            return redirect('inpatient/admissions')->with('success', 'Successfully admitted a patient');
        } catch (\Exception $e) {
            \DB::rollback();
            return back()->with('error', 'A problem occured while admitting the patient. ' . $e->getMessage());
        }
    }

    public function checkInPatient(Request $request)
    {
        $visit = new Visit;
        $visit->patient = $request->patient_id;
        $visit->clinic = session('clinic', 1);
        $visit->inpatient = true;
        $req = RequestAdmission::where("patient_id", $request->patient_id)->first();

        if ($request->has('purpose')) {
            $visit->purpose = null;
        }

        $visit->payment_mode = $request->payment_mode;
        $visit->user = $request->user()->id;

        if ($request->has('scheme')) {
            $visit->scheme = $request->scheme;
        }
        //External Doctor Requests (Applies to Externally Ordered Labs)
        if ($request->has('external_doctor')) {
            $visit->external_doctor = $request->external_doc;
        }

        $visit->save();

        if ($request->has('to_nurse')) { //quick way to forge an entry to nurse section
            $this->checkin_at($request, $visit->id, 'nursing');
        }

        return $visit->id;
    }

    /**
     * New way to checkin patient
     * @param $visit
     * @param $place
     * @return bool
     */
    private function checkin_at(Request $request, $visit, $place)
    {
        $department = $place;
        $destination = NULL;
        if (intval($place) > 0) {
            $destination = (int)$department;
            $department = 'doctor';
        }
        $destinations = VisitDestinations::firstOrNew(['visit' => $visit, 'department' => ucwords($department)]);
        $destinations->destination = $destination;
        $destinations->user = $request->user()->id;
        return $destinations->save();
    }

    public function admissionList()
    {
        $admissions = Admission::where("is_discharged", 0)->get();
        return view('Inpatient::admission.admissionList', compact('admissions'));
    }

    public function admissionLogs()
    {
        $admissions = Admission::where("is_discharged", 1)->get();
        return view('Inpatient::admission.admission_logs', compact('admissions'));
    }

    public function admitAwaiting()
    {
        $patient_awaiting = Visit::where('inpatient', 'on')->get();
        return view('Inpatient::admission.admitAwaiting', compact('patient_awaiting'));
    }

    public function admit_check(Request $request)
    {
        try {
            $account = PatientAccount::latestBalance($request->patient_id);
            if ($account == null) {
                $account = new PatientAccount;
                $account->patient = $request->patient_id;
                $account->save();
            }
            $account_balance = $account->balance;

            if (Deposit::all()->count() <= 0) {
                return array('status' => 'insufficient', 'description' => 'There are no deposits');
            }
            $deposit_amount = Deposit::find($request->depositTypeId)->cost;
            if ($account_balance < ($deposit_amount)) {
                return array('status' => 'insufficient', 'description' => 'Your account balance is Kshs. ' . (number_format($account_balance, 2)) . '. Please deposit kshs. ' . number_format(($deposit_amount - $account_balance), 2) . ' for the selected deposit type.');
            }

            return array('status' => 'sufficient', 'description' => 'Your account balance is sufficient');

        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return array('status' => 'insufficient', 'description' => $e->getMessage());
        }
    }

    public function managePatient($id, $visit_id)
    {

        $patient = Patients::findorFail($id)->first();

        $ward_assigned = WardAssigned::where("visit_id", $visit_id)->first();

        $ward = Ward::find($ward_assigned->ward_id)->first();
        $admission = Admission::where('patient_id', $id)->where("visit_id", $visit_id)->first();
        ///the vitals taken during visits
        /* all the visits for this patient */
        $vitals = null;
        $doctor_note = null;

        if (count(Visit::where('patient', $id)->get()) > 0) {
            $visit_id = Visit::where('patient', $id)->orderBy('created_at', 'desc')->first()->id;
            $vitals = Vitals::where('visit_id', $visit_id)->orderBy("updated_at", "DESC")->get()->map(function ($item) {
                return [
                    "id" => $item->id,
                    "height" => $item->height,
                    "weight" => $item->weight,
                    "bmi" => number_format($this->helper->calculateBMI($item->weight, $item->height), 2),
                    "bmi_status" => $this->helper->getBMIStatus($this->helper->calculateBMI($item->weight, $item->height)),
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
            });

            $once_only_prescriptions = Prescriptions::where('visit', $visit_id)->where("type", 0)->where("for_discharge", 0)->orderBy("updated_at", "DESC")->get();
            $regular_prescriptions = Prescriptions::where('visit', $visit_id)->where("type", 1)->where("for_discharge", 0)->orderBy("updated_at", "DESC")->get();

            $discharge_prescriptions = Prescriptions::where('visit', $visit_id)->where("for_discharge", 1)->orderBy("updated_at", "DESC")->get();

            $doctorsNotes = Notes::where('visit_id', $visit_id)->where("type", 1)->get();
            $nursesNotes = Notes::where('visit_id', $visit_id)->where("type", 0)->get();
            $nursingCarePlans = NursingCarePlan::where('visit_id', $visit_id)->get();
            $transfusions = BloodTransfusion::where('visit_id', $visit_id)->get();
            $fluidbalances = FluidBalance::where("visit_id", $visit_id)->get()->map(function ($item) {
                return
                    [
                        "id" => $item->id,
                        "intravenous_infusion_instructions" => $item->intravenous_infusion,
                        "intake_intravenous" => unserialize($item->intake_intravenous),
                        "intake_alimentary" => unserialize($item->intake_alimentary),
                        "output" => unserialize($item->output),
                        "recorded_by" => $item->user->profile->fullName,
                        "recorded_on" => $item->time_recorded . " " . $this->carbon->parse($item->date_recorded)->format('d/m/Y')
                    ];
            });

            $investigations = Investigations::where("visit", $visit_id)->where("type", "laboratory")->get()->map(function ($item) {
                return
                    [
                        "id" => $item->id,
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
            });

            $charges = $this->buildChargeSheet($visit_id, 1);

        }

        $bpChart = $this->getCharts($patient->id, $admission->id);
        $tempChart = $this->getTemperatureChart($patient->id, $admission->id);

        return view('Inpatient::admission.manage_patient', compact('tempChart', 'investigations', 'bpChart', 'patient', 'ward', 'admission', 'vitals', 'doctorsNotes', 'nursesNotes', 'once_only_prescriptions', 'regular_prescriptions', 'nursingCarePlans', 'transfusions', 'fluidbalances', 'discharge_prescriptions', 'charges'));
    }

    private function getTemperatureChart($patient, $admission)
    {
        $t = Temperature::wherePatientId($patient)->whereAdmissionId($admission)->get();
        return \Charts::create('line', 'highcharts')
            ->title('Temperature Chart')
            ->elementLabel('Temperature')
            ->labels($t->pluck('date'))
            ->values($t->pluck('temperature'))
            ->template('material')
            ->container('temp_chart')
            ->width(0)
            ->height(0);
        /* return \Charts::realtime(
             url('api/inpatient/v1/get/temperature'), 2000, 'line', 'highcharts')
             ->values($t->pluck('value'))
             ->labels($t->pluck('created_at'))
             ->responsive(false)->elementLabel('Temperature')
             ->height(300)
             ->width(0)
             ->title('Temperature')
             ->valueName('temperature');*/

    }

    /**
     * @param $patient
     * @param $admission
     * @return mixed
     */
    private function getCharts($patient, $admission)
    {
        $bp = BloodPressure::wherePatientId($patient)->whereAdmissionId($admission)->get();
        return \Charts::create('line', 'highcharts')
            ->title('Blood Pressure Chart')
            ->elementLabel('Blood Pressure')
            ->labels($bp->pluck('date'))
            ->values($bp->pluck('value'))
            ->template('material')
            ->container('bp_chart')
            ->width(0)
            ->height(0);

    }


    public function movePatient($id, $visit_id)
    {
        $admission = Admission::where("visit_id", $visit_id)->first();
        $v = Visit::find($visit_id)->first();
        $patient = Patients::find($id)->first();
        $acc = PatientAccount::firstOrNew(['patient' => $patient->id]);
        $balance = $acc->balance;
        $ward = Ward::find($admission->ward_id);
        $bed = Bed::find($admission->bed_id)->number;
        $beds = Bed::where('status', 'available')->get();
        $wards = Ward::all()->except($admission->ward_id);
        return view('Inpatient::admission.movePatient', compact('v', 'wards', 'bed', 'beds', 'ward', 'balance', 'patient', 'admission'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDischargeNote(Request $request)
    {
        if ($request->type == 'discharge') {
            DischargeNote::create([
                'summary_note' => $request->summaryNote,
                'admission_id' => 2,
                'doctor_id' => \Auth::user()->id,
                'visit_id' => $request->visit_id
            ]);
        } else {
            DischargeNote::create(array(
                'case_note' => $request->caseNote,
                'admission_id' => 2,
                'doctor_id' => \Auth::user()->id,
                'visit_id' => $request->visit_id,
            ));
        }
        return redirect()->back()->with('success', 'Successfully saved discharge note..');

    }

    public function request_discharge($id, $visit_id)
    {
        $c = RequestDischarge::where('visit_id', $visit_id)->count();
        //THE Doctor should be able to write a note
        $v = Visit::findorfail($visit_id);
        $patient = Patients::findorfail($v->patient);
        $account = PatientAccount::firstOrNew(['patient' => $patient->id]);
        $wardCharges = 0;
        $wards = WardAssigned::where('visit_id', $visit_id)->get();
        foreach ($wards as $ward) {
            $wardCharges += ($ward->price/** date_diff($ward->discharged_at,$ward->created_at) */);
        }
        $recuCharges = 0;
        //subscribed reccurrent charges
        $rcnt = RecurrentCharge::where('visit_id', $visit_id)->where('status', 'unpaid')->get();
        foreach ($rcnt as $recurrent) {
            //nursing charges times no. of days..
            $recuCharges += NursingCharge::find($recurrent->recurrent_charge_id)->cost/** date_diff($ward->discharged_at,$ward->created_at) */
            ;
        }
        $totalCharges = $wardCharges + $recuCharges;

        if ($c > 0) {
            return back()->with('error', 'Request has already been submitted!');
        }

        $admission = Admission::where("visit_id", $visit_id)->first();

        return view('Inpatient::admission.request_patient_discharge', compact('admission'));
    }

    public function requested_discharge()
    {
        $discharges = RequestDischarge::all();
        return view('Inpatient::admission.discharges', compact('discharges'));
    }

    public function confirm_discharge($visit_id)
    {
        $admission = Admission::where("visit_id", $visit_id)->first();
        $discharge_prescriptions = Prescriptions::where('visit', $visit_id)->where("for_discharge", 1)->orderBy("updated_at", "DESC")->get();
        return view('Inpatient::admission.discharge_patient', compact('admission', 'discharge_prescriptions'));
    }

    public function Cancel_discharge($visit_id)
    {
        $v = RequestDischarge::find($visit_id);
        $v->delete();
        return redirect()->back()->with('success', 'Successfully canceled the discharge request');
    }

    public function postDischargePatient(Request $r)
    {
        $vid = $r->visit_id;
        //the discharge for
        if ($r->type != 'case') {
            $r->dateofdeath = null;
            $r->timeofdeath = null;
        }
        //check the pending reccurrent charges.
        ///the ward's charges
        $wardCharges = 0;
        $wards = WardAssigned::where('visit_id', $r->visit_id)->get();
        foreach ($wards as $ward) {
            $wardCharges += ($ward->price/** date_diff($ward->discharged_at,$ward->created_at) */);
        }
        $recuCharges = 0;
        //subscribed reccurrent charges
        $rcnt = RecurrentCharge::where('visit_id', $r->visit_id)->where('status', 'unpaid')->get();
        foreach ($rcnt as $recurrent) {
            //nursing charges times no. of days..
            $recuCharges += NursingCharge::find($recurrent->recurrent_charge_id)->cost/** date_diff($ward->discharged_at,$ward->created_at) */
            ;
        }
        $totalCharges = $wardCharges + $recuCharges;

        //check patient account balance..
        $visit = Visit::find($r->visit_id);
        $acc = PatientAccount::firstOrNew(['patient' => $visit->patient]);
        $acc_balance = $acc->balance;
        if ($totalCharges > $acc_balance) {
            return redirect()->back()->with('error', 'You have a pending charges of Kshs.'
                . number_format($totalCharges) . '. Your account balance is Kshs. '
                . number_format($acc_balance) . '. Please deposit Kshs.'
                . number_format(($totalCharges - $acc_balance)) . ' to complete the discharge process.');
            $validator = Validator::make($r->all(), []);
            $validator->errors()
                ->add('amount', 'You have pending reccurrent charges. Please make the payment to proceed with the discharge');
            return redirect()->back()->withErrors($validator);
        }
        //charge the recurrent charges from the patient acc.
        $acc->update(['balance' => ($acc->balance - $totalCharges)]);

        Discharge::create([
            'visit_id' => $r->visit_id,
            'doctor_id' => \Auth::user()->id,
            'DischargeNote' => $r->DischargeNote,
            'dateofdeath' => $r->dateofdeath,
            'timeofdeath' => $r->timeofdeath,
            'type' => $r->type
        ]);

        //release the bed for reassignment.
        $admission = Admission::orderBy('created_at', 'desc')->where('visit_id', $vid)->first();
        $bed = Bed::find($admission->visit_id);
        $bed->update(['status' => 'available']);
        //record these charges to the patient
        //remove the discharge request.
        $request_dis = RequestDischarge::orderBy('created_at', 'desc')->where('visit_id', $vid)->first();
        if ($request_dis) {
            $request_dis->delete();
        }
        return redirect('/evaluation/inpatient/admit')->with('success', 'Successfully discharged patient');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        $bed = Bed::find($request->bed_id);
        $bed->update([
            'number' => $request->bed_no,
            'type' => $request->bed_type,
            'ward' => $request->ward
        ]);
        return redirect()->back()->with('success', 'Successfully edited a bed');
    }

    public function buildChargeSheet($visit_id, $type = null)
    {
        $wardCharges = 0;
        $recuCharges = 0;
        $totalNursingAndWardCharges = 0;
        $totalInvestigationsCharges = 0;
        $totalProceduresCharges = 0;
        $totalConsumablesCharges = 0;
        $totalDispensedDrugs = 0;
        $totalDischargeDrugs = 0;
        $totalBill = 0;

        $admission = Admission::where('visit_id', $visit_id)->first();
        // Check total days based on discharge and admission date
        $daysAdmitted = $admission->created_at->diffInDays($this->carbon->now());
        $wards = WardAssigned::where('visit_id', $visit_id)->get();
        $rcnt = RecurrentCharge::where('visit_id', $visit_id)->get();

        $done_investigations = get_inpatient_investigations($visit_id);
        $consumption_list = InpatientConsumable::whereVisit($visit_id)->get();
        $done_procedures = get_inpatient_investigations($visit_id, 'procedure');
        $dispensed_drugs = Prescriptions::where("visit", $visit_id)->where("status", 1)->get();
        $discharge_drugs = Prescriptions::where("visit", $visit_id)->where("for_discharge", 1)->get();
        $admission = Admission::where("visit_id", $visit_id)->first();

        // Calculate Totals 
        foreach ($wards as $ward) {
            $days_if_discharged = ((($this->carbon->parse($ward->discharged_at)->diffInDays($ward->created_at)) > 0) ? ($this->carbon->parse($ward->discharged_at)->diffInDays($ward->created_at)) : 1);
            $days_not_discharged = (($this->carbon->now()->diffInDays($ward->created_at) > 0) ? $this->carbon->now()->diffInDays($ward->created_at) : 1);
            $wardCharges += $ward->price * (($ward->discharged_at != null) ? $this->carbon->parse($ward->discharged_at)->diffInDays($ward->created_at) : ($this->carbon->now()->diffInDays($ward->created_at) > 0) ? $this->carbon->now()->diffInDays($ward->created_at) : 1);
            //subscribed reccurrent charges
            foreach ($rcnt as $recurrent) {
                //nursing charges times no. of days..
                $recuCharges += ($ward->discharged_at != null) ? NursingCharge::find($recurrent->recurrent_charge_id)->cost * $days_if_discharged : NursingCharge::find($recurrent->recurrent_charge_id)->cost * $days_not_discharged;
            }
        }

        foreach ($dispensed_drugs as $d) {
            $totalDispensedDrugs += $admission->visit->payment_mode == 'cash' ? $d->drugs->prices[0]->cash_price * Administration::where("prescription_id", $d->id)->count() : $d->drugs->prices[0]->credit_price * Administration::where("prescription_id", $d->id)->count();
        }

        foreach ($discharge_drugs as $d) {
            $totalDischargeDrugs += $admission->visit->payment_mode == 'cash' ? $d->drugs->prices[0]->cash_price * Administration::where("prescription_id", $d->id)->count() : $d->drugs->prices[0]->credit_price * Administration::where("prescription_id", $d->id)->count();
        }

        $totalNursingAndWardCharges = $wardCharges + $recuCharges;
        $totalInvestigationsCharges = $done_investigations->sum('amount');
        $totalConsumablesCharges = $consumption_list->sum('amount');
        $totalProceduresCharges = $done_procedures->sum('amount');
        $totalPrescriptionCharges = $totalDispensedDrugs + $totalDischargeDrugs;

        $totalBill = $totalNursingAndWardCharges + $totalInvestigationsCharges + $totalConsumablesCharges + $totalProceduresCharges + $totalPrescriptionCharges;

        $charges = ['admission' => $admission, 'recurrent_charges' => $rcnt, 'wards' => $wards, 'investigations' => $done_investigations, 'consumables' => $consumption_list, 'procedures' => $done_procedures, 'dispensed_drugs' => $dispensed_drugs, 'discharge_drugs' => $discharge_drugs, 'totalNursingAndWardCharges' => $totalNursingAndWardCharges, 'daysAdmitted' => $daysAdmitted, 'totalPrescriptionCharges' => $totalPrescriptionCharges, 'totalBill' => $totalBill];

        if ($type == 1) {
            return $charges;
        }

        return view('Inpatient::admission.print.charge_sheet', compact('charges'));

        // $pdf =\PDF::loadView('Inpatient::admission.print.charge_sheet', ['charges' => $charges]);        
        // $pdf->setPaper('a4', 'portrait');
        // return $pdf->download('charge_sheet_'.str_random(10).'.pdf');
    }

    public function buildDischargeSummary($visit_id)
    {
        $discharge = Discharge::where("visit_id", $visit_id)->first();
        $admission = Admission::where("visit_id", $visit_id)->first();
        $prescriptions = Prescriptions::where("visit", $visit_id)->where("for_discharge", 1)->get();
        return view('inpatient::admission.print.discharge_summary', compact('admission', 'discharge', 'prescriptions'));

        // $pdf =\PDF::loadView('inpatient::admission.print.discharge_summary', compact('admission', 'discharge', 'prescriptions'));        
        // $pdf->setPaper('a4', 'portrait');
        // return $pdf->download('discharge_summary_'.str_random(10).'.pdf');
    }

}
