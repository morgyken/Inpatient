<?php

namespace Ignite\Inpatient\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Ignite\Inpatient\Entities\Ward;
use Ignite\Inpatient\Entities\NursingCharge;

use Ignite\Inpatient\Http\Requests\WardRequest;

use Validator;

class WardController extends AdminBaseController
{
    protected $ward;

    public function __construct(Ward $ward)
    {
        parent::__construct();
        $this->ward = $ward;
    }

    public function getWardCharges($id){
        return NursingCharge::where("ward_id", $id)->get(['id','name','cost']);

    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $wards = $this->ward->all();

        return view('Inpatient::wards.index', ['wards' => $wards]);
    }

    public function getAll(){
        $wards = $this->ward->get()->map(function($w){
            return [
                'id' => $w->id,
                'number' => $w->number,
                'name'  => $w->name,
                'cost' =>  'Ksh. '.$w->cost,
                'category' => $w->category,
                'gender' => $w->gender,
                'age_group' => $w->age_group,
                'created_on' => $w->created_at->format('d/m/Y H:i a')
            ];
        })->toArray();

        $data = [];
        foreach($wards as $key => $ward){
            $data[] = [
                $ward['number'],
                $ward['name'], 
                $ward['gender'],
                $ward['age_group'],
                $ward['cost'],
                $ward['created_on'],
                '<a href="'.url("/inpatient/ward/".$ward["id"]."/delete").'" class="btn btn-danger btn-xs">Delete</a>
                                        <button class="btn btn-primary btn-xs edit" id="'.$ward["id"].'" >Edit</button>'
            ];
        }

        return response()->json(['data' => $data]);
    }


    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(WardRequest $request)
    {
        // dd(request()->all());
        try{

            $request['category'] = 'inpatients';
            $this->ward->create($request->all());
            return redirect()->back()->with('success', 'Ward added Sucesfully!');

        }catch (\Exception $e){
            return redirect()->back()->with('error', 'Something Went Wrong '.$e->getMessage());
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
        \DB::beginTransaction();
         try{
          
            $ward = Ward::findOrFail($id);

            if (!$request->has('number')){
                $ward->number = random_int(4);
            }

            $ward->update($request->all());

            \DB::commit();

            return redirect()->back()->with('success','Ward updated Sucesfully!' );

        }catch (\Exception $e){
            \DB::rollback();
            return redirect()->back()->with('error', 'Something went Wrong');
        }

    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        \DB::beginTransaction();
        try{
            $item= $this->ward->where("id",$id)->first();
            $item->delete();
            \DB::commit();
            return redirect()->back()->with('success', 'Ward Deleted Sucessfully!');
        }catch(\Exception $e){
            \DB::rollback();
            return redirect()->back()->with('success', 'Ward Deleted Sucessfully!');
        }
    }
}
