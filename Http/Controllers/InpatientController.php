<?php

namespace Ignite\Inpatient\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Validator;
use Session;

use Ignite\Inpatient\Entities\Admission;
use Ignite\Inpatient\Entities\Deposit;
use Ignite\Inpatient\Entities\RequestDischarge;
use Ignite\Inpatient\Entities\DischargeNote;
use Ignite\Evaluation\Entities\FinancePatientAccounts;
use Ignite\Inpatient\Entities\NursingCharge;
use Ignite\Inpatient\Entities\RequestAdmission;
use Ignite\Inpatient\Entities\Visit;
use Ignite\Inpatient\Entities\Ward;
use Ignite\Inpatient\Entities\Bed;
use Ignite\Inpatient\Entities\BedPosition;
use Ignite\Reception\Entities\Patients;
use Illuminate\Contracts\View\Factory;
use Ignite\Users\Entities\Roles;
use Ignite\Users\Entities\UserRoles;
use Ignite\Users\Entities\User;

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

    /**
     * InpatientController constructor.
     * @param Patients $patients
     * @param RequestAdmission $request_admission
     * @param Roles $roles
     * @param User $user
     * @param UserRoles $user_roles
     */
    public function __construct(Patients $patients, RequestAdmission $request_admission, Roles $roles, User $user, UserRoles $user_roles, Visit $visit)
    {
        parent::__construct();
        $this->request_admission = $request_admission;
        $this->roles = $roles;
        $this->user_roles = $user_roles;
        $this->user = $user;
        $this->patients = $patients;
        $this->visit = $visit;
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $patientIds = $this->patients->where('id', '!=', null)->get(['id'])->toArray();
        $patients = $this->patients->all();
        return view('inpatient::index', ['patientIds'=>$patientIds, 'patients' => $patients]);
    }

    public function awaiting()
    {
        $patientIds = $this->request_admission->where('id', '!=', null)->get(['patient_id'])->toArray();
        $patients = $this->request_admission->all();
        return view('inpatient::awaiting_admission', ['patientIds'=>$patientIds, 'patients' => $patients]);
    }

    public function requestAdmission(Request $request){
      if(RequestAdmission::find($request->patient_id)->count() < 0){
        RequestAdmission::findOrCreate($request->toArray());
        \Session::flash('success','Admission request successful');
        return view('inpatient.index');
      }else{
        return back()->with('error', 'The patient has already requested admission');
      }
    }

    public function cancel($id) {
        $admit_r = RequestAdmission::find($id);
        $admit_r->delete();
        return redirect()->back()->with('success', 'Successfully canceled admission request');
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
        return view('inpatient::admission.admit_form', compact('doctors', 'patient', 'wards', 'deposits', 'visit', 'beds','bedpositions', 'request_id', 'admissions'));
    }

    public function admit(Request $request){

      try{
        $request['bedposition_id'] = $request->bed_position_id;
        /* recurrent charges. */
        //indicate the recurrent charges for the patient.
        if ($request->recurrent_charge) {
            foreach ($request->recurrent_charge as $rc) {
                RecurrentCharge::create([
                    'visit_id' => $request->visit_id,
                    'recurrent_charge_id' => $rc,
                    'status' => 'unpaid'
                ]);
            }
        }

        $p_id = $request->patient_id;
        if (count(FinancePatientAccounts::where('patient', $request->patient_id)->get()) > 0) {
            $patientAcc = FinancePatientAccounts::where('patient', $request->patient_id)->first();
        } else {
            $validator = Validator::make($request->all(), []);
            $validator->errors()->add('deposit', 'Please top up your account');
            return back()->withErrors($validator);
        }

//        $patientAcc -> update(['balance'=>$patientAcc->balance - $request->amount]);

        if ($request->admission_doctor == 'other') {
            $request['external_doctor'] = $request->external_doc;
            $request['doctor_id'] = null;
        } else {
            $request['external_doctor'] = null;
            $request['doctor_id'] = $request['admission_doctor'];
        }

        if (count(RequestAdmission::where('patient_id', $request->patient_id)->get()) > 0) {
            $request_admission = RequestAdmission::where('patient_id', $request->patient_id)->first();
            $request_admission->delete();
        }

        /* apply charges */
        if ($request->payment_mode == 'cash') {
            $acc = PatientAccount::where('patient_id', $request->patient_id)->first();
            $depo_cost = Deposit::find($request->deposit);
            if ($depo_cost->cost > $acc->balance) {
                $validator = Validator::make($request->all(), []);
                $validator->errors()->add('deposit', 'Please top up your account');
                Session::flash('error', 'error');
                return back()->withErrors($validator);
            }
            // $ward_cost = Ward::find($request->ward_id);

            FinancePatientAccounts::create([
                'debit' => $depo_cost->cost,
                'credit' => 0.00,
                'details' => 'Charged for ' . $depo_cost->name,
                'reference' => 'deposit_charge_' . str_random(5),
                'patient' => $request->patient_id
            ]);
            
            $request['cost'] = $depo_cost->cost;
            /* debit the patient account */
            $acc = PatientAccount::where('patient_id', $request->patient_id)->first();
            $acc->update(['balance' => $acc->balance - $request['cost']]);
        }

        $request->patient_id = $p_id;

        // Let's admit our guy
        Admission::create($request->all());
        $adm_request = RequestAdmission::find($request->request_id);

        if (count($adm_request)) {
            //remove this admission request
            $adm_request->delete();
        }

        //the bed should change status to occupied
        if (count(Bed::find($request->bed_id))) {
            $bed = Bed::find($request->bed_id);
            $bed->update(['status' => 'occupied']);
        }

        //create a record in ward awarded..
        $price = Ward::find($request->ward_id)->cost;
        WardAssigned::create([
            'visit_id' => $request->visit_id,
            'ward_id' => $request->ward_id,
            /* 'admitted_at'=> $request->admitted_at, */
            /* 'discharged_at', */
            'price' => $price,
        ]);

        return redirect('inpatient/admissions')->with('success', 'Successfully admitted a patient');
      }catch(\Exception $e){
        return back()->with('error', 'A problem occured while admitting the patient. '. $e->getMessage());
      }
    }

    public function admissionList() {
        $admissions = Admission::all();
        return view('Inpatient::admission.admissionList', compact('admissions'));
    }

    public function admitAwaiting() {
        $patient_awaiting = Visit::where('inpatient', 'on')->get();
        return view('Evaluation::inpatient.admitAwaiting', compact('patient_awaiting'));
    }

    public function admit_check(Request $request) {
        $account_balance = PatientAccount::where('patient_id', $request->patient_id)->first();

        if (count($account_balance)) {
            $account_balance = $account_balance->balance;
        } else {
            $account_balance = 0;
        }
        /* get the cost of the ward.. */
        $ward_cost = Ward::find($request->ward_id)->cost;

        $deposit_amount = Deposit::find($request->depositTypeId)->cost;
        if ($account_balance < ($deposit_amount )) {
            return array('status' => 'insufficient', 'description' => 'Your account balance is Kshs. ' . (number_format($account_balance, 2)) . '. Please deposit kshs. ' . number_format(($deposit_amount - $account_balance), 2) . ' for the selected deposit type.');
        }
        return array('status' => 'sufficient', 'description' => 'Your account balance is sufficient');
    }

    public function managePatient($id) {
        $patient = Patients::find($id);
        $admission = Admission::where('patient_id', $id)->first();
        $ward = Admission::where('patient_id', $id)->orderBy('created_at', 'desc')->first();
        ///the vitals taken during visits
        /* all the visits for this patient */
        $vitals = null;
        $doctor_note = null;

        if (count(Visit::where('patient', $id)->orderBy('created_at', 'desc')->get()) > 0) {
            $visit_id = Visit::where('patient', $id)->orderBy('created_at', 'desc')->first()->id;
            $vitals = Vitals::where('visit', $visit_id)->get();
            $doctor_note = DoctorNotes::where('visit', $visit_id)->first();
        }
        return view('Evaluation::inpatient.manage_patient', compact('patient', 'admission', 'ward', 'vitals', 'doctor_note'));
    }

    public function recordVitals(Request $request) {
        Vitals::create($request->all());
        return redirect()->back()->with('success', 'Recorded patient\'s vitals successfully.');
    }

    public function move_patient($visit) {
        $admission = Admission::find($visit);
        $visit = Admission::find($visit)->visit_id;
        $v = Visit::find($visit);
        $patient = Patients::find($v->patient);
        $acc = PatientAccount::where('patient_id', $v->patient)->first();
        if (count($acc)) {
            $balance = $acc->balance;
        } else {
            $balance = 0;
        }
        $ward = Ward::find($admission->ward_id);
        $bed = Bed::find($admission->bed_id)->number;
        $beds = Bed::where('status', 'available')->get();
        $wards = Ward::all();
        return view('Evaluation::.inpatient.movePatient', compact('v', 'wards', 'bed', 'beds', 'ward', 'balance', 'patient', 'admission'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDischargeNote(Request $request) {
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

    public function request_discharge($id) {
        //THE Doctor should be able to write a note
        $visit_id = $id;
        $v = Visit::findorfail($visit_id);
        $patient = Patients::findorfail($v->patient);
        $account = PatientAccount::where('patient_id', $patient->id)->first();

        $wardCharges = 0;
        $wards = WardAssigned::where('visit_id', $id)->get();
        foreach ($wards as $ward) {
            $wardCharges += ($ward->price /** date_diff($ward->discharged_at,$ward->created_at) */);
        }
        $recuCharges = 0;
        //subscribed reccurrent charges
        $rcnt = RecurrentCharge::where('visit_id', $id)->where('status', 'unpaid')->get();
        foreach ($rcnt as $recurrent) {
            //nursing charges times no. of days..
            $recuCharges += NursingCharge::find($recurrent->recurrent_charge_id)->cost /** date_diff($ward->discharged_at,$ward->created_at) */;
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

    public function requested_discharge(Request $request) {
        $discharges = RequestDischarge::all();
        return view('Evaluation::inpatient.discharges', compact('discharges'));
    }

    public function confirm_discharge($request_id) {
        $r = RequestDischarge::find($request_id);
        $v = Visit::find($r->visit_id);
        $patient = Patients::find($v->patient);
        return view('Evaluation::inpatient.discharge_patient', compact('v', 'patient'));
    }

    public function Cancel_discharge($visit_id) {
        $v = RequestDischarge::find($visit_id);
        $v->delete();
        return redirect()->back()->with('success', 'Successfully canceled the discharge request');
    }

    public function postDischargePatient(Request $r) {
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
            $wardCharges += ($ward->price /** date_diff($ward->discharged_at,$ward->created_at) */);
        }
        $recuCharges = 0;
        //subscribed reccurrent charges
        $rcnt = RecurrentCharge::where('visit_id', $r->visit_id)->where('status', 'unpaid')->get();
        foreach ($rcnt as $recurrent) {
            //nursing charges times no. of days..
            $recuCharges += NursingCharge::find($recurrent->recurrent_charge_id)->cost /** date_diff($ward->discharged_at,$ward->created_at) */;
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

    public function delete_service($id) {
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
