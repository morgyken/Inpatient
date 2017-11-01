<?php

namespace Ignite\Inpatient\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Ignite\Inpatient\Entities\AdmissionType;
use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Inpatient\Http\Requests\AdmissionTypeRequest;
use Ignite\Inpatient\Repositories\AdmissionTypeRepository;

class AdmissionTypeController extends AdminBaseController
{
    /*
    * Dependencies
    */
    protected $admissionTypeRepository;


    public function __construct(AdmissionTypeRepository $admissionTypeRepository)
    {
        parent::__construct();

        $this->admissionTypeRepository = $admissionTypeRepository;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $admissionTypes = $this->admissionTypeRepository->all();

        return view('inpatient::admission.types.index', compact('admissionTypes'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  AdmissionTypeRequest $request
     * @return Response
     */
    public function store(AdmissionTypeRequest $request)
    {
        $admission = $this->admissionTypeRepository->create(request()->all());

        return $admission ? redirect()->back()->with('success', 'Admission Type Added Sucesfully!') : 
                            redirect()->back()->with('error', 'Something Went Wrong ');
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
     * Get a specified resource
     */
    public function edit($id)
    {
        return $this->admissionTypeRepository->findById($id);
    }

    /**
     * Update the specified resource in storage.
     * @param  AdmissionType $admissionType
     * @return Response
     */
    public function update($id)
    {
        $admissionType = $this->admissionTypeRepository->findById($id);

        $editedType = $admissionType->update(request()->all());

        return $editedType ?redirect()->back()->with('success', 'Admission Type Ppdated Sucesfully!') : 
                            redirect()->back()->with('error', 'Something Went Wrong ');
    }

    public function listing()
    {
        $admissionTypes = $this->admissionTypeRepository->all();

        $jsonAdmissionTypes = $this->admissionTypeRepository->jsonReady($admissionTypes);

        return response()->json($jsonAdmissionTypes);
    }
}
