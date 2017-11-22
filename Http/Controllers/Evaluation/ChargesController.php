<?php

namespace Ignite\Inpatient\Http\Controllers\Evaluation;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Ignite\Inpatient\Entities\Charge;
use Ignite\Inpatient\Library\Interfaces\EvaluationInterface;

class ChargesController extends Controller implements EvaluationInterface
{
    /*
    * Define the view that this class should return
    */
    protected $view = "inpatient::admissions.evaluation.charges";

    /*
    * Returns a view to be displayed
    */
    public function getData($admission)
    {
        return [
            'admission' => $admission,
            'patient' => $admission->patient,
            'active' => 'charges',
            'charges' => $this->charges($admission)
        ];
    }

    /*
    * Return the view 
    */
    public function getView()
    {
        return $this->view;
    }

    /*
    * Get the deposit to be included in the general charges
    */
    public function getDeposit($admissionType)
    {
        return [
            'name' => $admissionType->name,

            'units' => 1,

            'price' => $admissionType->deposit,

            'total' =>  $admissionType->deposit * 1
        ];
    }

    /*
    * Get the recurring charges on an admission
    */
    public function getRecurringCharges($admission)
    {
        $days = Carbon::today()->diffInDays(Carbon::parse($admission->created_at)) + 1;

        return Charge::where('type', 'recurring')->get()->map(function($charge) use($days){
            return [

                'name' => $charge->name,

                'units' => $days,

                'price' => $charge->cost,

                'total' => $charge->cost * $days,

            ];
        })->toArray();
    }

    /*
    * Get the bed charges on an admission
    */
    public function getBedCharges($admission) 
    {
        $days = Carbon::today()->diffInDays(Carbon::parse($admission->created_at));

        $patient = $admission->patient;

        $ward = $admission->ward;

        $price = $admission->patient->schemes ? $ward->insurance_cost : $ward->cash_cost;

        return [
            
            'name' => "Bed Charges",

            'units' => $days,

            'price' => $price,

            'total' => $price * $days,

        ];
    }

    /*
    * Get the general charges during admission of the patient
    */
    public function general($admission)
    {
        $admissionType = $admission->patient->admissionRequest->filter(function($request) use($admission){

            return $request->visit_id == $admission->visit->id;

        })->first()->admissionType;

        $recurring = $this->getRecurringCharges($admission);

        $deposit = $this->getDeposit($admissionType);

        $bedCharges = $this->getBedCharges($admission); 

        array_push($recurring, $deposit);

        array_push($recurring, $bedCharges);

        return $recurring;
    }

    /*
    * Gets the charge of a particular object from their controller
    */
    public function charges($admission)
    {
        $generalTotal =  0;

        foreach( $this->general($admission) as $charge)
        {
            $generalTotal = $generalTotal + $charge['total'];
        }

        // $depositCharges = 
        return [
            'general' => $this->general($admission),

            'generalTotal' => $generalTotal
        ];
    }
}
