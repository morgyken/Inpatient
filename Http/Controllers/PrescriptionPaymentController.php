<?php

namespace Ignite\Inpatient\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Ignite\Inpatient\Repositories\PrescriptionRepository;
use Ignite\Inpatient\Repositories\PrescriptionPaymentRepository;

class PrescriptionPaymentController extends Controller
{
    protected $prescriptionRepository, $prescriptionPaymentRepository;
    
    /*
    * Inject the various dependencies that will be required
    */
    public function __construct(PrescriptionRepository $prescriptionRepository, PrescriptionPaymentRepository $prescriptionPaymentRepository)
    {
        $this->prescriptionRepository = $prescriptionRepository;

        $this->prescriptionPaymentRepository = $prescriptionPaymentRepository;
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
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
    public function store($admission)
    {
        // dd(request()->all());

        foreach(request()->except("_token") as $id => $quantity)
        {
            $prescription = $this->prescriptionRepository->find($id);

            $this->prescriptionPaymentRepository->create($prescription, $quantity);
        }

        // $payment = $this->prescriptionPaymentRepository->create($prescription);
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
