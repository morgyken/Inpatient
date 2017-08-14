<?php

namespace Ignite\Inpatient\Http\Controllers;

use Dompdf\Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Ignite\Inpatient\Entities\Ward;
use Ignite\Inpatient\Entities\Bed;
use Ignite\Inpatient\Entities\BedPosition;
use Session;

class BedsController extends Controller
{
    protected $ward;
    protected $bed;
    protected $bedPosition;

    public function __construct(Ward $ward, Bed $bed, BedPosition $bedPosition)
    {
        $this->ward = $ward;
        $this->bed = $bed;
        $this->bedPosition = $bedPosition;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $wards = $this->ward->all();
        $beds = $this->bed->all();
        return view('inpatient::beds.index',  compact('beds', 'wards'));
    }

    public function bedPosition() {
        $wards = $this->ward->all();
        $bedpositions = $this->bedPosition->all();
        return view('inpatient::beds.index', compact('bedpositions', 'wards'));
    }

    public function addBedFormPost(Request $request) {
        $request['status'] = 'available';
        Bed::create($request->all());
        return redirect()->back()->with('success', 'successfully added a bed');
    }

    public function postaddBed(Request $request) {
        Bed::create($request->all());
        return redirect()->back()->with('success', 'Successfully added a new bed');
    }

    public function availableBeds($wardId) {
        //return wards bedpositions
        return Bedposition::where('ward_id', $wardId)->where('status', 'available')->get();
    }

     public function getAvailableBedPosition($ward) {
        return Bedposition::where('status', 'available')->where('ward_id', $ward)->get();
    }
   
    public function postbedPosition(Request $request) {
        Bedposition::create($request->all());


        return redirect()->back()->with('success', 'Successfully added a new bed position to ward ');
    }

    public function change_bed(Request $request) {
        $admission = Admission::find($request->admission_id);

        if ($admission->ward_id != $request->ward_id) {
            //ward change to be indicated here..
            $ward_assigned = WardAssigned::where('visit_id', $admission->visit_id)->orderBy('created_at', 'desc')->first();
            if (count($ward_assigned)) {
                $ward_assigned->update(['discharged_at' => date("Y-m-d G:i:s")]);
            }
            //assign another ward
            $ward = Ward::find($request->ward_id);
            WardAssigned::create([
                'visit_id' => $admission->visit_id,
                'ward_id' => $request->ward_id,
                'price' => $ward->cost
            ]);
        }
        $admission->update([
            'ward_id' => $request->ward_id,
            'bed_id' => $request->bed_id,
            'bedPosition_id' => $request->bedposition_id
        ]);
        //if there is ward change

        return redirect()->back()->with('success', 'Successfully moved the patient');
    }

    public function deletebedPosition($request) {
        $bedpos = Bedposition::find($request);
        $bedpos->delete();
        return redirect()->back()->with('success', 'Successfully deleted a bed position');
    }

    public function postdelete_bed($value) {
        $bed = Bed::find($value);
        $bed->delete();
        return redirect()->back()->with('success', 'Successfully deleted a bed');
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
                'ward_id'   => 'required',
                'number'    => 'required',
                'type'      => 'required',
                'status'    => 'required'
            ]);

            $item = $this->bed;

            if($request->has('number')){
                $item->number = get_next_bed_number();//generate a sequence;
            }

            $item = $this->bed->create($request->all());

            $item->save();

            Session::flash('message', 'Bed Added Successfully!');

        }catch (Exception $e){
            Session::flash('message', 'Oops Something Went Wrong!');

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
        try{
            $item = $this->bed->find($request->bed_id);
            $this->validate($request,[
                'number' => 'required',
                'type' => 'required',
                'ward' => 'required'
            ]);

            $item->update($request->all());
            Session::flash('message', 'Bed Updated Sucessfully!');

            return redirect()->route('inpatient.beds.index');
        }catch(\Exception $e){
            Session::flas('message', 'Oops Something Went Wrong!');
            //return an error page or redirect back()
            return redirect()->route('inpatient.index.beds');
        }

    }

    /**
     * Remove the specified resource from storage.
     * @param $id
     * @return Response
     */
    public function destroy($id)
    {
        try{
            $bed = Bed::findorfail($request->bed_id);
            $bed->delete();
            Session::flash('message', 'Bed Deleted Sucessfully!');
            return redirect()->back()->with('success', 'Successfully deleted the bed');
        }catch(\Exception $e){
            return back()->with('error', 'An error occured while deleting the bed'); 
        }
    }
}
