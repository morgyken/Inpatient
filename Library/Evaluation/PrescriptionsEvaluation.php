<?php
namespace Ignite\Inpatient\Library\Evaluation;

use Ignite\Evaluation\Entities\Visit;
use Ignite\Evaluation\Entities\Dispensing;
use Ignite\Evaluation\Entities\Prescriptions;
use Ignite\Evaluation\Entities\VisitDestinations;

use Ignite\Inpatient\Library\Traits\DrugsTrait;
use Ignite\Inpatient\Library\Traits\PrescriptionsTrait;

use Ignite\Inpatient\Library\Interfaces\EvaluationInterface;

class PrescriptionsEvaluation implements EvaluationInterface
{
    use PrescriptionsTrait, DrugsTrait;

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