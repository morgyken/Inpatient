<?php

namespace Ignite\Inpatient\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Ignite\Inpatient\Repositories\BedRepository;
use Ignite\Inpatient\Repositories\WardRepository;
use Ignite\Inpatient\Repositories\BedTypeRepository;

class BedController extends AdminBaseController
{
    protected $bedRepository;
    
    /*
    * Inject the various dependencies that will be required
    */
    public function __construct(BedRepository $bedRepository, WardRepository $wardRepository, BedTypeRepository $bedTypeRepository)
    {
        parent::__construct();

        $this->bedRepository = $bedRepository;

        $this->wardRepository = $wardRepository;

        $this->bedTypeRepository = $bedTypeRepository;
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $bedTypes = $this->bedTypeRepository->all();

        $wards = $this->wardRepository->all();

        $beds = $this->bedRepository->all();

        return view('inpatient::settings.beds.index', compact('wards', 'beds', 'bedTypes'));
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
     public function destroy($id)
     {
         $deletes = $this->bedRepository->delete($id);
 
         return $deletes ? redirect()->back()->with(['success' => 'Bed removed successfully']) :
                           redirect()->back()->with(['error' => 'Something went wrong']);
     }
}
