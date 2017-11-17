<?php

namespace Ignite\Inpatient\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Ignite\Inpatient\Repositories\WardRepository;
use Ignite\Inpatient\Repositories\ChargeRepository;

class ChargeController extends AdminBaseController
{
    protected $chargeRepository, $wardRepository;
    
    /*
    * Inject dependencies
    */
    public function __construct(ChargeRepository $chargeRepository, WardRepository $wardRepository)
    {
        parent::__construct();

        $this->chargeRepository = $chargeRepository;

        $this->wardRepository = $wardRepository;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $charges = $this->chargeRepository->all();

        $wards = $this->wardRepository->all();

        return view('inpatient::settings.charges.index', compact('charges', 'wards'));
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
        dd(request()->all());
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
