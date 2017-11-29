<?php

namespace Ignite\Inpatient\Library\Traits;

use Ignite\Evaluation\Entities\DispensingDetails;

trait PrescriptionsTrait
{
    public function transform($prescription)
    {
        $dispensed = $this->dispensed($prescription);

        $remaining = $prescription->quantity - $dispensed;

        return [
            'id' => $prescription->id,

            'drug_id' => $prescription->drug,

            'drug' => $prescription->drugs->name,

            'price' => $this->getDrugPrice($prescription),
            
            'dose' => $prescription->dose,
            
            'prescribed' => $prescription->quantity,

            'remaining' => $remaining,

            'dispensed' => $dispensed,

            'stock' => $prescription->drugs->stocks->quantity,

            'total' => $this->toDispense($prescription) * $this->getDrugPrice($prescription),

            'stopped' => $prescription->stopped ? 'stopped' : 'active',

            'can_dispense' => $this->canDispense($prescription, $remaining),

            'to_dispense' => $this->toDispense($prescription),

            'is_dispensed' => $prescription->payment
        ];
    } 

    /*
    * Checks to see if the prescription can be dispensed
    */
    public function canDispense($prescription, $remaining)
    {
        if($prescription->stopped or $remaining <= 0)
        {
            return false;
        }

        return true;
    }
    
    /*
    * Gets the sum of all the drugs that have been dispensed on a prescription object
    */
    public function dispensed($prescription)
    {
        $batches = $prescription->dispensing->pluck('id')->toArray();

        $details = DispensingDetails::whereIn('batch', $batches)->get();

        return $details->pluck('quantity')->sum();
    }    

    /*
    * Shows the amount of drugs to dispense
    */
    public function toDispense($prescription)
    {
        $method = trim(mconfig('evaluation.options.prescription_method.' . $prescription->method));

        $dispensed = $this->dispensed($prescription);
        
        $remaining = $prescription->quantity - $dispensed;

        if($method == 'b.i.d')
        {
            $times = 2;
        }
        elseif($method == 't.i.d')
        {
            $times = 3;
        }
        elseif($method == 'q.i.d')
        {
            $times = 4;
        }
        else
        {
            $times = 1;
        }
        
        $dose = $prescription->take * $times;

        return $remaining < $dose ? $remaining : $dose;
    }

    /*
    * returns a drug price
    */
    public function getDrugPrice($prescription)
    {
        if(!$prescription)
        {
            return 0;
        }

        $visit = $prescription->visits;

        $drug = $prescription->drugs;

        if($drug)
        {
            return $visit->patient_scheme ? $drug->insurance_p : $drug->cash_price;
        }

        return 0;
    }

    /*
    * Makes the data more friendly to a datatable
    */
    public function table()
    {
        $data = $this->data()['prescriptions']->map(function($prescription){

            if($prescription['stopped'] == 'stopped')
            {
                $button = "<button class='btn btn-xs btn-warning' id='stop-'".$prescription['id']." 
                    value='".json_encode($prescription)."' >".
                    "<i class='fa fa-info-circle'></i> Stopped
                </button>";
            }
            else
            {
                $button = "<button class='btn btn-xs btn-danger stop-drug' id='stop-'".$prescription['id']." 
                    value='".json_encode($prescription)."' >".
                    "<i class='fa fa-ban'></i> Stop
                </button>";
            }
            
            return [
                $prescription['drug'],
                $prescription['dose'],
                $prescription['prescribed'],
                $prescription['dispensed'],
                $prescription['stopped'],
                $prescription['remaining'],
                0,
                $button
            ];

        })->toArray();

        return compact('data');
    }
}
