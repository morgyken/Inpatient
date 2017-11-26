<?php

namespace Ignite\Inpatient\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;

use Ignite\Evaluation\Entities\Visit;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Ignite\Inpatient\Repositories\PrescriptionRepository;

class DispenseController extends AdminBaseController
{
    protected $prescriptionRepository;

    public function __construct(PrescriptionRepository $prescriptionRepository)
    {
        parent::__construct();

        $this->prescriptionRepository = $prescriptionRepository;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index($visitId)
    {
        $visit = Visit::find($visitId);

        $patient = $visit->patients;

        $admission = $visit->admission;

        $prescriptions = $this->prescriptionRepository->getPrescriptions($visit);

        $data = compact('prescriptions', 'patient', 'admission', 'visit');

        return view('inpatient::admissions.evaluation.dispense-drugs', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('inpatient::create');
    }

    /*
     * Dispense the drugs into the database
     */
    public function store($visitId)
    {
        $this->prescriptionRepository->dispenseDrugs($visitId);

        return redirect()->back()->with('success', 'drugs dispensed successfully');
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
