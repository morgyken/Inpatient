<?php

namespace Ignite\Inpatient\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Ignite\Inpatient\Entities\Deposit;
use Ignite\Inpatient\Entities\DischargeNote;
use Ignite\Inpatient\Entities\NursingCharge;
use Ignite\Inpatient\Entities\RequestAdmission;
use Ignite\Inpatient\Entities\Visit;
use Ignite\Reception\Entities\Patients;
use Illuminate\Contracts\View\Factory;
use Ignite\Users\Entities\Roles;
use Ignite\Users\Entities\UserRoles;
use Ignite\Users\Entities\User;

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
    public function index()
    {
        $patientIds = $this->request_admission->where('id', '!=', null)->get(['patient_id'])->toArray();
        $patients = $this->request_admission->all();
        return view('inpatient::index' ['patientIds'=>$patientIds, 'patients' => $patients]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('inpatient::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('inpatient::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('inpatient::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
