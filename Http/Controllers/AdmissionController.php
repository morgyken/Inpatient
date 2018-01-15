<?php

namespace Ignite\Inpatient\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;

use Ignite\Inpatient\Entities\Ward;
use Ignite\Inpatient\Entities\Charge;
use Ignite\Inpatient\Entities\ChargeSheet;
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

        dd($admissions);

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

        return view('inpatient::admissions.create', compact('admissionRequest', 'doctors', 'wards'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(AdmissionRequest $request)
    {
        $admissionRequest = request()->get('inpatient_request_admission_id');

        $visit = $this->admissionRequestRepository->find($admissionRequest)->visits;

        $wardId = request()->get('ward_id');

        $ward = Ward::find($wardId);

        $wardPrice = $visit->patients->schemes ? $ward->insurance_cost : $ward->cash_cost;

        ChargeSheet::create([
            'visit_id' => $visit->id,
            'ward_id' => $wardId,
            'price' => $wardPrice
        ]);

        foreach(Charge::all() as $charge)
        {
            ChargeSheet::create([
                'visit_id' => $visit->id,
                'charge_id' => $charge->id,
                'price' => $charge->cost
            ]);
        }

        $admission = request()->except(['_token', 'inpatient_request_admission_id']);

        $admission = $this->admissionRepository->create($admission);

        $admission->visit->admission_request_id = $admissionRequest;

        $admission->visit->save();

        $this->admissionRequestRepository->delete($admissionRequest);

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
