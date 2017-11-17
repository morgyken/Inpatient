<?php

namespace Ignite\Inpatient\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Ignite\Inpatient\Http\Requests\WardRequest;
use Ignite\Inpatient\Repositories\WardRepository;

class WardController extends AdminBaseController
{
    protected $wardRepository;
    /*
    * Inject the various dependencies into the system
    */
    public function __construct(WardRepository $wardRepository)
    {
        parent::__construct();

        $this->wardRepository = $wardRepository;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $wards = $this->wardRepository->all();
        
        return view('inpatient::settings.wards.index', compact('wards'));
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
    public function store(WardRequest $request)
    {
        $ward = $this->wardRepository->create(request()->except('_token'));

        return $ward ? redirect()->back()->with(['success' => 'Ward listed successfully']) :
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
        $deletes = $this->wardRepository->delete($id);
        
        return $deletes ? redirect()->back()->with(['success' => 'Ward removed successfully']) :
                          redirect()->back()->with(['error' => 'Something went wrong']);
    }
}
