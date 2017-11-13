<?php

namespace Ignite\Inpatient\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Ignite\Inpatient\Repositories\BedRepository;
use Ignite\Inpatient\Repositories\WardRepository;

class BedController extends AdminBaseController
{
    protected $bedRepository;
    
    /*
    * Inject the various dependencies that will be required
    */
    public function __construct(BedRepository $bedRepository, WardRepository $wardRepository)
    {
        parent::__construct();

        $this->bedRepository = $bedRepository;

        $this->wardRepository = $wardRepository;
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $wards = $this->wardRepository->all();

        $beds = $this->bedRepository->all();

        return view('inpatient::beds.index', compact('wards', 'beds'));
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
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $bed = $this->bedRepository->create(request()->all());

        return $bed ? redirect()->back()->with(['success' => 'Bed created successfully']) :
                      redirect()->back()->with(['error' => 'Something went wrong']);
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
