<?php

namespace Ignite\Inpatient\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Validator;
use Session;
use Lava;
use Carbon\Carbon;

use Ignite\Inpatient\Entities\Admission;
use Ignite\Inpatient\Entities\BloodPressure;
use Ignite\Inpatient\Entities\Deposit;
use Ignite\Inpatient\Entities\DischargeNote;

use Ignite\Inpatient\Entities\Notes;
use Ignite\Inpatient\Entities\NursingCharge;
use Ignite\Inpatient\Entities\PatientAccount;
use Ignite\Inpatient\Entities\RequestAdmission;
use Ignite\Inpatient\Entities\RequestDischarge;
use Ignite\Inpatient\Entities\Temperature;
use Ignite\Inpatient\Entities\Visit;
use Ignite\Inpatient\Entities\Vitals;
use Ignite\Inpatient\Entities\Ward;
use Ignite\Inpatient\Entities\WardAssigned;
use Ignite\Inpatient\Entities\Bed;
use Ignite\Inpatient\Entities\BedPosition;

use Ignite\Reception\Entities\Patients;
use Illuminate\Contracts\View\Factory;

use Ignite\Users\Entities\Roles;
use Ignite\Users\Entities\User;
use Ignite\Users\Entities\UserRoles;

use Ignite\Evaluation\Entities\VisitDestinations;
use Ignite\Evaluation\Entities\FinancePatientAccounts;
use Ignite\Evaluation\Entities\Prescriptions;
use Ignite\Evaluation\Repositories\EvaluationRepository;
use Ignite\Evaluation\Entities\Investigations;

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

    /**
     * InpatientController constructor.
     * @param Patients $patients
     * @param RequestAdmission $request_admission
     * @param Roles $roles
     * @param User $user
     * @param UserRoles $user_roles
     */
    public function __construct(Carbon $carbon, Patients $patients, RequestAdmission $request_admission, Roles $roles, User $user, UserRoles $user_roles, Visit $visit, EvaluationRepository $evaluation)
    {
        parent::__construct();
        $this->__require_assets();

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

    private function __require_assets()
    {

        $css_assets = [
            'vertical-tabs.css' => m_asset('inpatient:css/vertical-tabs.css')
        ];

        $js_assets = [
            'doctor-investigations.js' => m_asset('evaluation:js/doctor-investigations.js'),
            'doctor-treatment.js' => m_asset('evaluation:js/doctor-treatment.js'),
            'doctor-next-steps.js' => m_asset('evaluation:js/doctor-next-steps.min.js'),
            'doctor-notes.js' => m_asset('evaluation:js/doctor-notes.min.js'),
            'doctor-opnotes.js' => m_asset('evaluation:js/doctor-opnotes.min.js'),
            'doctor-prescriptions.js' => m_asset('evaluation:js/doctor-prescriptions.min.js'),
            'doctor-visit-date.js' => m_asset('evaluation:js/doctor-set-visit-date.min.js'),
            'nurse-vitals.js' => m_asset('evaluation:js/nurse-vitals.js'),
            //'order-investigation.js' => m_asset('evaluation:js/doctor-treatment.min.js'),
            'nurse_eye_preliminary.js' => m_asset('evaluation:js/nurse_eye_preliminary.min.js'),
            'inpatient-scripts.js' => m_asset('inpatient:js/inpatient-scripts.js')
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
        $patientIds = $this->patients->where('id', '!=', null)->get(['id'])->toArray();
        $patients = $this->patients->all();
        return view('inpatient::index', ['patientIds' => $patientIds, 'patients' => $patients]);
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
            return redirect('/inpatient/admit')->with('success', 'Admission request successful');
        } else {
            return back()->with('error', 'The patient has already requested admission');
        }
    }

    public function cancel($id)
    {
        $admit_r = RequestAdmission::find($id);
        $admit_r->delete();
        return redirect()->back()->with('success', 'Successfully canceled admission request');
    }

    public function admitWalkInPatient($id)
    {
        //dd($id);
        $doctor_rule = Roles::where('name', 'Doctor')->first();
        $doctor_ids = UserRoles::where('role_id', $doctor_rule->id)
            ->get(['user_id'])
            ->toArray();

        $doctors = User::findMany($doctor_ids);

        $patient = Patients::find($id);

        // $visit = Visit::find($visit_id);
        $wards = Ward::all();
        $beds = Bed::all();
        $bedpositions = BedPosition::all();
        $deposits = Deposit::all();
        // $request_id = RequestAdmission::where('visit_id', $visit_id)->first()->id;
        $admissions = NursingCharge::all();
        return view('inpatient::admission.admit_form', compact('doctors', 'patient', 'wards', 'deposits', 'beds', 'bedpositions', 'admissions'));
    }

    public function admitPatientForm($id, $visit_id)
    {
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
    }

    public function admit(Request $request)
    {
        \DB::beginTransaction();
        try {
            $admitted = Admission::where("patient_id", $request->patient_id)->get();
            $visit = Visit::where("patient", $request->patient_id)->first();

            $request->visit_id = ($visit != null) ? $visit->id : $this->checkInPatient($request);

            if (count($admitted) > 0) {
                return redirect("/inpatient/admit")->with('error', "Patient already admitted");
            }

            $account = PatientAccount::where('patient_id', $request->patient_id)->first();

            if (count($account)) {
                $account_balance = $account->balance;
            } else {
                $p = new PatientAccount;
                $p->patient_id = $request->patient_id;
                $p->balance = 0;
                $p->save();
                $account_balance = 0;
            }

            if ($request->admission_doctor == 'other') {
                $request['external_doctor'] = $request->external_doc;
                $request['doctor_id'] = null;
            } else {
                $request['external_doctor'] = null;
                $request['doctor_id'] = $request->admission_doctor;
            }

            $ward_cost = Ward::find($request->ward_id)->first()->cost;
            $deposit = Deposit::find($request->deposit)->first();
            $deposit_amount = $deposit->cost;
            $request['cost'] = $ward_cost + $deposit_amount;

            /* Apply charges - Cash for now */

            // if ($request->payment_mode == 'cash') {

            //     $acc = PatientAccount::where('patient_id', $request->patient_id)->first();

            //     if ($deposit_amount > $acc->balance) {
            //         $validator = Validator::make($request->all(), []);
            //         $validator->errors()->add('deposit', 'Please top up your account');
            //         Session::flash('error', 'Please top up your account');
            //         return back()->withErrors($validator);
            //     }


            //     FinancePatientAccounts::create([
            //         'debit' => $deposit_amount,
            //         'credit' => 0.00,
            //         'details' => 'Charged for ' . $deposit->name,
            //         'reference' => 'deposit_charge_' . str_random(5),
            //         'patient' => $request->patient_id
            //     ]);

            //     // debit the patient account
            //     if($acc != null){
            //         $acc->update(['balance' => $acc->balance - $request['cost']]);
            //     }
            // }

            $adm_request = (isset($request->visit_id)) ? RequestAdmission::whereRaw("patient_id = '" . $request->patient_id . "' AND visit_id = '" . $request->visit_id . "'")
                ->first() : RequestAdmission::where("patient_id", $request->patient_id)->first();

            $request['reason'] = (count($adm_request) > 0) ? $adm_request->reason : null;

            // Let's admit our guy
            $a = new Admission;
            $a->patient_id = $request->patient_id;
            $a->doctor_id = $request->doctor_id;
            $a->ward_id = $request->ward_id;
            $a->bed_id = $request->bed_id;
            $a->cost = $request->cost;
            $a->reason = $request->reason;
            $a->external_doctor = $request->external_doctor;
            $a->visit_id = $request->visit_id;
            $a->bedposition_id = $request->bedposition_id;

            $a->save();

            if (count($adm_request) > 0) {
                //remove this admission request
                $adm_request->delete();
            }

            //the bed should change status to occupied
            if (count(Bed::find($request->bed_id)) > 0) {
                $bed = Bed::find($request->bed_id)->first();
                $bed->update(['status' => 'occupied']);
            }

            $admission = $a->where("patient_id", $request->patient_id)->where("visit_id", $request->visit_id)->first();

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
            $this->checkin_at($request, $visit->id, 'nurse');
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
        $admissions = Admission::all();
        return view('Inpatient::admission.admissionList', compact('admissions'));
    }

    public function admitAwaiting()
    {
        $patient_awaiting = Visit::where('inpatient', 'on')->get();
        return view('Inpatient::admission.admitAwaiting', compact('patient_awaiting'));
    }

    public function admit_check(Request $request)
    {
        $account_balance = PatientAccount::where('patient', $request->patient_id)->first();

        if (count($account_balance)) {
            $account_balance = $account_balance->balance;
        } else {
            $account_balance = 0;
        }
        /* get the cost of the ward.. */
        // $ward_cost = Ward::find($request->ward_id)->cost;
        $deposit_amount = Deposit::find($request->depositTypeId)->cost;
        if ($account_balance < ($deposit_amount)) {
            return array('status' => 'insufficient', 'description' => 'Your account balance is Kshs. ' . (number_format($account_balance, 2)) . '. Please deposit kshs. ' . number_format(($deposit_amount - $account_balance), 2) . ' for the selected deposit type.');
        }
        return array('status' => 'sufficient', 'description' => 'Your account balance is sufficient');
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
            $vitals = Vitals::where('visit_id', $visit_id)->get();
            $prescriptions = Prescriptions::where('visit', $visit_id)->get();
            $doctor_note = Notes::where('visit_id', $visit_id)->first();
        }
        $bpChart = $this->getCharts($patient->id, $admission->id);
        $tempChart = $this->getTemperatureChart($patient->id, $admission->id);
//        dd(get_defined_vars());
//        return view('Inpatient::admission.manage_patient', compact('tempChart', 'bpChart', 'patient', 'ward', 'admission', 'vitals', 'doctor_note', 'prescriptions'));


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

        return view('Inpatient::admission.manage_patient', compact('tempChart', 'investigations', 'bpChart', 'patient', 'ward', 'admission', 'vitals', 'doctor_note', 'prescriptions'));
    }

    private function getTemperatureChart($patient, $admission)
    {
        $t = Temperature::wherePatientId($patient)->whereAdmissionId($admission)->get();
        return \Charts::create('line', 'highcharts')
            ->title('Temperature Chart')
            ->elementLabel('Temperature')
            ->labels($t->pluck('created_at'))
            ->values($t->pluck('temperature'))
            ->template('material')
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
            ->labels($bp->pluck('created_at'))
            ->values($bp->pluck('value'))
            ->template('material')
            ->width(0)
            ->height(0);

    }

    public function recordVitals(Request $request)
    {
        \DB::beginTransaction();
        try {
            $v = Vitals::find("visit_id", $request->visit);
            if ($v == null) {
                Vitals::create($request->all());
            } else {
                $v->update($request->all());
            }
            \DB::commit();
            return redirect()->back()->with('success', 'Recorded patient\'s vitals successfully.');
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('error', 'An error occured. ' . $e->getMessage());
        }
    }

    public function movePatient($id, $visit_id)
    {
        $admission = Admission::where("visit_id", $visit_id)->first();
        $v = Visit::find($visit_id)->first();
        $patient = Patients::find($id)->first();
        $acc = PatientAccount::where('patient_id', $id)->first();
        if (count($acc)) {
            $balance = $acc->balance;
        } else {
            $balance = 0;
        }
        $ward = Ward::find($admission->ward_id);
        $bed = Bed::find($admission->bed_id)->number;
        $beds = Bed::where('status', 'available')->get();
        $wards = Ward::all();
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
                'doctor_id' => \Auth::user()->id,
                'visit_id' => $request->visit_id
            ]);
        } else {
            DischargeNote::create(array(
                'case_note' => $request->caseNote,
                'doctor_id' => \Auth::user()->id,
                'visit_id' => $request->visit_id,
            ));
        }
        return redirect()->back()->with('success', 'Successfully saved discharge note..');

    }

    public function request_discharge($id)
    {
        //THE Doctor should be able to write a note
        $visit_id = $id;
        $v = Visit::findorfail($visit_id);
        $patient = Patients::findorfail($v->patient);
        $account = PatientAccount::where('patient_id', $patient->id)->first();

        $wardCharges = 0;
        $wards = WardAssigned::where('visit_id', $id)->get();
        foreach ($wards as $ward) {
            $wardCharges += ($ward->price/** date_diff($ward->discharged_at,$ward->created_at) */);
        }
        $recuCharges = 0;
        //subscribed reccurrent charges
        $rcnt = RecurrentCharge::where('visit_id', $id)->where('status', 'unpaid')->get();
        foreach ($rcnt as $recurrent) {
            //nursing charges times no. of days..
            $recuCharges += NursingCharge::find($recurrent->recurrent_charge_id)->cost/** date_diff($ward->discharged_at,$ward->created_at) */
            ;
        }
        $totalCharges = $wardCharges + $recuCharges;

        return view('Evaluation::inpatient.request_patient_discharge', compact('account', 'patient', 'visit_id', 'v', 'totalCharges'));

        //add a record to request discharge table
        $user_id = (\Auth::user()->id);

        RequestDischarge::create([
            'doctor_id' => $user_id,
            'visit_id' => $id,
            'status' => 'unconfirmed'
        ]);
        return redirect()->back()->with('success', 'Successfully requested for discharge');
    }

    public function requested_discharge(Request $request)
    {
        $discharges = RequestDischarge::all();
        return view('Evaluation::inpatient.discharges', compact('discharges'));
    }

    public function confirm_discharge($request_id)
    {
        $r = RequestDischarge::find($request_id);
        $v = Visit::find($r->visit_id);
        $patient = Patients::find($v->patient);
        return view('Evaluation::inpatient.discharge_patient', compact('v', 'patient'));
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
        $acc = PatientAccount::find($visit->patient);
        $acc_balance = 0;
        if ($acc) {
            $acc_balance = $acc->balance;
        }
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

    public function delete_service($id)
    {
        $service = NursingCharge::find($id);
        if ($service) {
            $service->delete();
        }
        return redirect()->back()->with('success', 'Successfully deleted a recurrent charge.');
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

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
