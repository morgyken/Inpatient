<?php

namespace Ignite\Inpatient\Http\Controllers;

use Ignite\Inpatient\Entities\Deposit;
use Ignite\Inpatient\Entities\DischargeNote;
use Ignite\Inpatient\Entities\NursingCharge;
use Ignite\Inpatient\Entities\RequestAdmission;
use Ignite\Inpatient\Entities\Visit;
use Ignite\Reception\Entities\Patients;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Ignite\Users\Entities\Roles;
use Ignite\Users\Entities\UserRoles;
use Ignite\Users\Entities\User;

/**
 * @property Roles roles
 * @property  beds
 * @property  beds
 * @property  wards
 * @property  wards
 * @property  visit
 * @property  visit
 */
class InpatientController extends Controller
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
    public function admit()
    {
        $patientIds = $this->request_admission->where('id', '!=', null)->get(['patient_id'])->toArray();
        $patients = $this->request_admission->all();
        return view('inpatient:admission.admit', compact('patients', 'patientIds'));
    }

    /**
     * @param $id
     * @param $visitId
     * @return Factory|\Illuminate\View\View
     * @return Factory|\Illuminate\View\View
     */
    public function admit_patient($id ,  $visit_id)
    {
        $doctor_rule = $this->roles->where('name', 'Doctor')->first();
        $doctor_ids = $this->user_roles->where('role_id', $doctor_rule->id)->get(['user_id'])->toArray();
        $doctors = $this->user->findMany($doctor_ids);


        $patient = $this->patients->find($id);
        $visit = $this->visit->find($visit_id);
        $wards = $this->wards->all();
        $beds = $this->beds->all();
        $deposits = Deposit::all();
        $request_id = $this->request_admission->where('visit_id', $visit_id)->first()->id;
        $admissions = NursingCharge::all();
        return view('evaluation::inpatient.admit_form', compact('doctors', 'patient', 'wards', 'deposits', 'visit', 'beds', 'request_id', 'admissions'));
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


}
