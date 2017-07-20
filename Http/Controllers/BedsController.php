<?php

namespace Ignite\Inpatient\Http\Controllers;

use Dompdf\Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Ignite\Inpatient\Entities\Bed;
use Ignite\Inpatient\Entities\BedPosition;

class BedsController extends Controller
{
    protected $bed;
    protected $bedPosition;
    public function __construct(Bed $bed, BedPosition $bedPosition)
    {
        $this->bed = $bed;
        $this->position = $bedPosition;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $items = $this->bed->all();
        return view('inpatient::beds.index', ['items' => $items]);
    }


    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $number = substr($request->ward_id, 4);
        try{
            $this->validate($request, [
                'ward_id' => 'required',
                'number' => 'required',
                'type' => 'required',
                'status' => 'required'
            ]);

            $item = $this->bed;

            if($request->has('number')){
                $item->number = get_next_bed_number();//generate a sequence;
            }

            $item = $this->bed->create($request->all());

            $item->save();

            \Session::flash('message', 'Bed Added Successfully!');

        }catch (Exception $e){
            \Session::flash('message', 'Oops Something Went Wrong!');

        }


        return redirect()->route('impatient.index');
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
