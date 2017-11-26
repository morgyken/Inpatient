<?php
namespace Ignite\Inpatient\Library\Evaluation;

use Ignite\Evaluation\Entities\Visit;
// use Ignite\Evaluation\Entities\Dispensing;
use Ignite\Evaluation\Entities\Prescriptions;
// use Ignite\Evaluation\Entities\VisitDestinations;

// use Ignite\Inpatient\Library\Traits\DrugsTrait;
use Ignite\Inpatient\Library\Traits\PrescriptionsTrait;

use Ignite\Inpatient\Library\Interfaces\EvaluationInterface;

class PrescriptionsEvaluation implements EvaluationInterface
{
    use PrescriptionsTrait;

    protected $visit; 

    /*
    * Initialize the visit property
    */
    public function __construct(Visit $visit)
    {
        $this->visit = $visit;
    }

    /*
    * Retrieves the data that will be displayed on the view
    */
    public function data()
    {
        $prescriptions = $this->visit->prescriptions->map(function($prescription){
            
            return $this->transform($prescription);

        });

        return compact('prescriptions');
    }

    /*
    * Saves the required item into the database
    */
    public function persist()
    {
        $quantity = request()->get('quantity');

        $cost = $this->getProductPrice(request()->only(['visit', 'drug']));

        Prescriptions::create(request()->except('_token'))->payment()->create([

            'price' => $cost, 'cost' => $cost * $quantity, 'quantity' => $quantity

        ]);
        
        $this->check_in_at('pharmacy');

        return true;
    }

    /*
    * Updates a prescription
    */
    public function modify()
    {
        return Prescriptions::where('id', request()->get('prescriptionId'))->update([
            'stopped' => true,
            'stop_reason' => request()->get('stop_reason')
        ]);
    }

    // /*
    // * Dispense drugs for an inpatient
    // */
    // public function dispense($visit)
    // {
    //     // \DB::beginTransaction();
    //     // dd(request()->all());

    //     dd(request()->all());

    //     //Save a new dispensing object
    //     // $dispensing = $visit->dispensing()->create(['user' => \Auth::user()->id ]);







    //     // $amount = 0;
    //     // $prescription = null;
    //     // foreach ($this->_get_selected_stack() as $index) {
    //     //     $item = 'item' . $index;
    //     //     $drug = 'drug' . $index;
    //     //     $qty = 'qty' . $index;
    //     //     $price = 'prc' . $index;
    //     //     $presc = 'presc' . $index;
    //     //     $disc = 'discount' . $index;

    //     //     $prescription = request()->get($presc);
    //     //     $details = new DispensingDetails;
    //     //     $details->batch = $dispensing->id;
    //     //     $details->product = request()->get($drug);
    //     //     $details->quantity = $this->request->$qty;
    //     //     $details->price = request()->get($price);
    //     //     $details->discount = request()->get($disc) ?? 0;
    //     //     $details->save();
    //     //     $sub_total = $details->quantity * $details->price;
    //     //     $amount += $sub_total;
    //     //     //adj stock
    //     //     $this->repo->take_dispensed_products($details);
    //     //     $this->updatePresc(request()->get($presc));
    //     // }
    //     // $dis->amount = $amount;
    //     // $dis->prescription = $prescription;
    //     // $dis->save();
    //     // \DB::commit();
    //     // return true;
    // }

    // private function _get_selected_stack($needle = null)
    // {
    //     $stack = [];
    //     $input = \request()->all();
    //     if (empty($needle)) {
    //         $needle = 'item';
    //     }
    //     foreach ($input as $key => $one) {
    //         if (starts_with($key, $needle)) {
    //             $stack[] = substr($key, strlen($needle));
    //         }
    //     }
    //     return $stack;
    // }





































    /*
    * Consider having this function in a very seperate Controller or a trait for crying out loud
    */
    private function check_in_at($place): bool
    {
        if ($place === 'treatment') {
            return true;
        }
        $department = $place;
        $destination = null;
        if ((int)$place > 0) {
            $destination = (int)$department;
            $department = 'doctor';
        }
        $destinations = VisitDestinations::firstOrNew([
            'visit' => request()->get('visit'), 'department' => ucwords($department)
        ]);
        $destinations->destination = $destination;
        $destinations->user = request()->get('user');
        return $destinations->save();
    }
}