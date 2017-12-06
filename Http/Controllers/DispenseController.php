<?php

namespace Ignite\Inpatient\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;

use Ignite\Evaluation\Entities\Visit;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Ignite\Inpatient\Repositories\PrescriptionRepository;
use Ignite\Inpatient\Entities\AdministerDrug;
use Auth;

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

    /*
     * Dispense the drugs into the database
     */
    public function store($visitId)
    {
        $this->prescriptionRepository->dispenseDrugs($visitId);

        return redirect()->back()->with('success', 'drugs dispensed successfully');
    }

    /*
    * Administer the drugs that have been dispensed
    */
    public function administer()
    {
        collect(request()->get('prescriptions'))->each(function($prescription){

            $prescription['user_id'] = Auth::user()->id;

            AdministerDrug::create($prescription);

        });

        return redirect()->back()->with('success', 'drugs administered successfully');
    }
}
