<?php

namespace Ignite\Inpatient\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Ignite\Inpatient\Entities\Ward;

class WardsController extends Controller
{

    protected $ward;

    public function __construct(Ward $ward)
    {
        $this->ward = $ward;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $items = $this->ward->all();

        return view('inpatient::admission.wards', ['items' => $items]);
    }


    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        try{
            $this->validate($request, [
                'name' => 'required',
                'number' => 'required',
                'age_group' => 'required',
                'cost' => 'required',
                'gender' => 'required',
            ]);

            if ($request->has('number')){
                $item = new Ward;
                $item->number = random_int(4);
            }
            $this->ward->create($request->all());
            \Session::flash('message', 'Ward added Sucesfully!');

            return redirect()->route('inpatient.wards.index');

        }catch (\Exception $e){

            \Session::flash('message', 'Something Went Wrong');
            return redirect()->route('inpatient.wards.index');
        }

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

    public function getRecordWard($id) {
        return Ward::findorfail($id);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
         try{
            $this->validate($request, [
                'name' => 'required',
                'number' => 'required',
                'age_group' => 'required',
                'cost' => 'required',
                'gender' => 'required',
            ]);

            $ward = Ward::findOrFail($id);

            if (!$request->has('number')){
                $ward->number = random_int(4);
            }

            $ward->update($request->all());

            \Session::flash('message', 'Ward updated Sucesfully!');

            return redirect()->url('inpatient/wards');

        }catch (\Exception $e){

            \Session::flash('message', 'Something went Wrong');
            return back();
        }

    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $item= $this->ward->find($id);
        $item->delete();

        \Session::flash('message', 'Ward Deleted Sucessfully!');
        return redirect()->route('inpatient.wards.index');
    }
}
