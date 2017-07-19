<?php

namespace Ignite\Inpatient\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class InpatientController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function admit()
    {
        $patientIds = RequestAdmission::where('id', '!=', null)->get(['patient_id'])->toArray();
        $patients = RequestAdmission::all();
        return view('inpatient:admit', compact('patients', 'patientIds'));
    }
    public function index()
    {
        return view('inpatient::index');
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
