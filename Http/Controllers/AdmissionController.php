<?php

namespace Ignite\Inpatient\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Ignite\Users\Repositories\UserRepository;
use Ignite\Inpatient\Entities\RequestAdmission;
use Ignite\Inpatient\Repositories\BedRepository;
use Ignite\Inpatient\Repositories\WardRepository;
use Ignite\Inpatient\Http\Requests\AdmissionRequest;
use Ignite\Inpatient\Repositories\AdmissionRepository;
use Ignite\Evaluation\Repositories\AdmissionRequestRepository;

class AdmissionController extends AdminBaseController
{
    protected $admissionRequestRepository, $userRepository;
    
    /*
    * Inject the various dependencies that will be required
    */
    public function __construct(AdmissionRequestRepository $admissionRequestRepository, WardRepository $wardRepository,
                                UserRepository $userRepository, AdmissionRepository $admissionRepository,
                                BedRepository $bedRepository)
    {
        parent::__construct();

        $this->admissionRequestRepository = $admissionRequestRepository;

        $this->userRepository = $userRepository;

        $this->wardRepository = $wardRepository;

        $this->bedRepository = $bedRepository;

        $this->admissionRepository = $admissionRepository;
    }

    /**
     * Display all the admissions
     */
    public function index()
    {
        $admissions = $this->admissionRepository->all();

        return view('inpatient::admission.index', compact('admissions'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create($id)
    {
        $admissionRequest = $this->admissionRequestRepository->find($id);

        $doctors = $this->userRepository->getUsersByRole('doctor');

        $wards = $this->wardRepository->all();

        $beds = $this->bedRepository->all();

        return view('inpatient::admission.create', compact('admissionRequest', 'doctors', 'wards', 'beds'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(AdmissionRequest $request)
    {
        $this->admissionRepository->create(request()->all());
        
        return redirect()->back()->with(['success' => 'Patient has been admitted']);
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
