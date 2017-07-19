<?php

namespace Ignite\Inpatient\Http\Controllers;

use Ignite\Inpatient\Entities\RequestAdmission;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Ignite\Users\Entities\Roles;
use Ignite\Users\Entities\UserRoles;
use Ignite\Users\Entities\User;

/**
 * @property Roles roles
 */
class InpatientController extends Controller
{

    protected $request_admission;
    protected $roles;
    protected $user_roles;
    protected $user;

    /**
     * InpatientController constructor.
     * @param RequestAdmission $request_admission
     * @param Roles $roles
     * @param User $user
     * @param UserRoles $user_roles
     */
    public function __construct(RequestAdmission $request_admission, Roles $roles, User $user, UserRoles $user_roles)
    {
        $this->request_admission = $request_admission;
        $this->roles = $roles;
        $this->user_roles = $user_roles;
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function admit()
    {
        $patientIds = $this->request_admission->where('id', '!=', null)->get(['patient_id'])->toArray();
        $patients = $this->request_admission->all();
        return view('inpatient:admit', compact('patients', 'patientIds'));
    }

    /**
     * @param $id
     * @param $visitId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function admit_patient($id , $visitId)
    {
        $doctor_rule = $this->roles->where('name', 'Doctor')->first();
        $doctor_ids = $this->user_roles->where('role_id', $doctor_rule->id)->get(['user_id'])->toArray();
        $doctors = $this->user->findMany($doctor_ids);


        $patient = Patients::find($id);
        $visit = $this->visit->find($visit_id);
        $wards = $this->wards->all();
        $beds = $this->beds->all();
        $deposits = Deposit::all();
        $request_id = $this->request_admission->where('visit_id', $visit_id)->first()->id;
        $admissions = NursingCharge::all();
        return view('evaluation::inpatient.admit_form', compact('doctors', 'patient', 'wards', 'deposits', 'visit', 'beds', 'request_id', 'admissions'));
    }

}