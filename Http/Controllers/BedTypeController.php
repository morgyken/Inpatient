<?php

namespace Ignite\Inpatient\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Ignite\Inpatient\Http\Requests\BedTypeRequest;
use Ignite\Inpatient\Repositories\BedTypeRepository;

class BedTypeController extends AdminBaseController
{
    protected $bedTypeRepository;

    /*
    * Inject dependencies
    */
    public function __construct(BedTypeRepository $bedTypeRepository)
    {
        parent::__construct();

        $this->bedTypeRepository = $bedTypeRepository;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $bedTypes = $this->bedTypeRepository->all();

        return view('inpatient::settings.bedtypes.index', compact('bedTypes'));
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
    public function store(BedTypeRequest $request)
    {
        $bedType = $this->bedTypeRepository->create(
            request()->except('_token')
        );

        return $bedType ? redirect()->back()->with(['success' => 'Bed type listed successfully']) :
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
        $deletes = $this->bedTypeRepository->delete($id);

        return $deletes ? redirect()->back()->with(['success' => 'Bed type deleted successfully']) :
                          redirect()->back()->with(['error' => 'Something went wrong']);
    }

}
