<?php

namespace Ignite\Inpatient\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Ignite\Reception\Entities\Patients;

class AdmissionFormController extends AdminBaseController
{
    /*
    * Inject the various dependencies that will be required
    */
    public function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('inpatient::index');
    }

    /*
     * Create the admission form
     */
    public function create($patientId)
    {
        $patient = Patients::findOrFail($patientId);

        $today = \Carbon\Carbon::today()->toFormattedDateString();

        return view('inpatient::admission.print.admission_letter', compact('patient', 'today'));
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
