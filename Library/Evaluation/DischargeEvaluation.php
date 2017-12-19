<?php

namespace Ignite\Inpatient\Library\Evaluation;

use Ignite\Evaluation\Entities\Visit;

use Ignite\Inpatient\Library\Interfaces\EvaluationInterface;

use Ignite\Inpatient\Entities\InpatientDoctorNotes;
use Ignite\Inpatient\Entities\DischargeType;
use Ignite\Inpatient\Entities\DischargeRequest;
use Ignite\Evaluation\Entities\Facility;

class DischargeEvaluation implements EvaluationInterface
{
    protected $visit; 
    
    /*
    * Initialize the visit property
    */
    public function __construct(Visit $visit)
    {
        $this->visit = $visit;
        
        $this->facility = Facility::where('name', 'inpatient')->first();
    }

    /*
    * Method must be defined, gets the prescriptions
    */
    public function data()
    {
        $dichargeTypes = DischargeType::all();

        $data = array();
        
        foreach($this->visit->prescriptions as $prescription)
        {
            if($prescription->facility_id == $this->facility->id && $prescription->for_discharge)
            {
                array_push($data, $prescription);
            }
        }

        $prescriptions = collect($data)->map(function($prescription){
            
            return $this->transform($prescription);

        });

        return compact('prescriptions', 'dichargeTypes');
    }

    /*
    * Persist the doctors notes into the database
    */
    public function persist()
    {
        //Get the Medications
        // (new PrescriptionsEvaluation($this->visit))->persist(); 

        $record = request()->all();

        $record['visit_id'] = $this->visit->id;

        return DischargeRequest::create($record);
    }

    /*
    * Transform the prescription
    */
    public function transform($prescription)
    {
        // $dispensed = $this->dispensed($prescription);

        // $remaining = $prescription->quantity - $dispensed;

        return [
            'id' => $prescription->id,

            'drug_id' => $prescription->drug,

            'drug' => $prescription->drugs->name,

            // 'price' => $this->getDrugPrice($prescription),
            
            'dose' => $prescription->dose,
            
            'prescribed' => $prescription->quantity,

            // 'remaining' => $remaining,

            // 'dispensed' => $dispensed,

            'stock' => $prescription->drugs->stocks->quantity,

            // 'total' => $this->toDispense($prescription) * $this->getDrugPrice($prescription),

            // 'stopped' => $prescription->stopped ? 'stopped' : 'active',

            // 'can_dispense' => $this->canDispense($prescription, $remaining),

            // 'to_dispense' => $this->toDispense($prescription),

            // 'administered' => $this->administered($prescription),

            // 'is_dispensed' => $prescription->payment
        ];
    } 

    /*
    * Makes the data more friendly to a datatable
    */
    public function table()
    {
        $data = $this->data()['prescriptions']->map(function($prescription){

            // if($prescription['stopped'] == 'stopped')
            // {
            //     $button = "<button class='btn btn-xs btn-warning' id='stop-'".$prescription['id']." 
            //         value='".json_encode($prescription)."' >".
            //         "<i class='fa fa-info-circle'></i> Stopped
            //     </button>";
            // }
            // else
            // {
            //     $button = "<button class='btn btn-xs btn-danger stop-drug' id='stop-'".$prescription['id']." 
            //         value='".json_encode($prescription)."' >".
            //         "<i class='fa fa-ban'></i> Stop
            //     </button>";
            // }
            
            return [
                $prescription['drug'],
                $prescription['dose'],
                $prescription['prescribed'],
                // $prescription['dispensed'],
                // $prescription['stopped'],
                // $prescription['remaining'],
                // $prescription['administered'],
                // $button
            ];

        })->toArray();

        return compact('data');
    }
}

