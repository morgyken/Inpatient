<?php
namespace Ignite\Inpatient\Library\Evaluation;

use Ignite\Evaluation\Entities\Visit;
use Ignite\Evaluation\Entities\Dispensing;
use Ignite\Evaluation\Entities\Prescriptions;
use Ignite\Evaluation\Entities\VisitDestinations;

use Ignite\Evaluation\Entities\Facility;
use Ignite\Inpatient\Library\Traits\DrugsTrait;
use Ignite\Inpatient\Library\Traits\PrescriptionsTrait;

use Ignite\Inpatient\Library\Interfaces\EvaluationInterface;
use Ignite\Inventory\Entities\StoreDepartment;
use Ignite\Inventory\Entities\StorePrescription;

class PrescriptionsEvaluation implements EvaluationInterface
{
    use PrescriptionsTrait, DrugsTrait;

    protected $visit, $facility; 

    /*
    * Initialize the visit property
    */
    public function __construct(Visit $visit)
    {
        $this->visit = $visit;

        $this->facility = Facility::where('name', 'inpatient')->first();
    }

    /*
    * Retrieves the data that will be displayed on the view
    * Filters prescriptions by inpatient facility only
    */
    public function data()
    {
        $data = array();

        foreach($this->visit->prescriptions as $prescription)
        {
            if($prescription->facility_id == $this->facility->id)
            {
                array_push($data, $prescription);
            }
        }

        $prescriptions = collect($data)->map(function($prescription){
            
            return $this->transform($prescription);

        });

        $clinics = StoreDepartment::all();

        return compact('prescriptions', 'clinics');
    }

    /*
    * Saves the required item into the database
    */
    public function persist()
    {
        $quantity = request()->get('quantity');

        $cost = $this->getProductPrice(request()->only(['visit', 'drug']));

        $prescription = request()->except('_token', 'clinic', 'store_id');

        $prescription['facility_id'] = $this->facility->id;

        $prescription = Prescriptions::create($prescription);

        $prescription->payment()->create([

            'price' => $cost, 'cost' => $cost * $quantity, 'quantity' => $quantity,

        ]);
        
        $this->check_in_at('pharmacy');

        StorePrescription::create([
            'product_id' => request('drug'),
            'store_id' => request('store_id'),
            'prescription_id' => $prescription->id,
            'quantity' => (int) $quantity,
            'facility' => 'inpatient'
        ]);

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