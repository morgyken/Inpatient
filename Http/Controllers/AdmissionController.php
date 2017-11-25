<?php

namespace Ignite\Inpatient\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Ignite\Users\Repositories\UserRepository;
use Ignite\Inpatient\Repositories\BedRepository;
use Ignite\Inpatient\Repositories\WardRepository;
use Ignite\Inpatient\Http\Requests\AdmissionRequest;
use Ignite\Inpatient\Repositories\AdmissionRepository;
use Ignite\Inpatient\Library\GeneralCharges;
use Ignite\Inpatient\Repositories\AdmissionRequestRepository;
use Ignite\Inpatient\Library\Traits\EvaluationTrait;

class AdmissionController extends AdminBaseController
{
    use EvaluationTrait;

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

        return view('inpatient::admissions.index', compact('admissions'));
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

        return view('inpatient::admissions.create', compact('admissionRequest', 'doctors', 'wards', 'beds'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(AdmissionRequest $request)
    {
        $admission = request()->except(['_token', 'inpatient_request_admission_id']);

        $admissionRequest = request()->get('inpatient_request_admission_id');

        $admission = $this->admissionRepository->create($admission);

        $admission->visit->admission_request_id = $admissionRequest;

        $admission->visit->save();

        $this->admissionRequestRepository->delete($admissionRequest);

        // (new GeneralCharges($admission->visit))->persist();

        return redirect('/inpatient/admissions')->with(['success' => 'Patient has been admitted']);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($admissionId, $evaluationItem)
    {
        $admission = $this->admissionRepository->find($admissionId);

        $evaluationObject = $this->getEvaluationObject($evaluationItem);

        $display = $this->display($admission, new $evaluationObject);

        return view($display['view'], $display['data']);
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

    /*
    * Receives evaluation items and initiates persistance given the object
    */
    public function evaluate($admissionId, $evaluationItem)
    {
        $admission = $this->admissionRepository->find($admissionId);

        $evaluationObject = $this->getEvaluationObject($evaluationItem);
        
        $persistance = $this->persist($admission, new $evaluationObject);

        return redirect()->back()->with(['success' => 'Action successfully completed']);
    }
}
