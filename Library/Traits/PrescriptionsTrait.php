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
            
            'dose' => $prescription->dose,
            
            'prescribed' => $prescription->quantity,

            'remaining' => $remaining,

            'dispensed' => $dispensed,

            'to_dispense' => $this->toDispense($prescription),

            'is_dispensed' => $prescription->payment
        ];
    } 
    
    /*
    * Gets all the drugs that have been dispensed on a prescription object
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
        $method = mconfig('evaluation.options.prescription_method.' . $prescription->method);

        switch($method)
        {
            case 'b.i.d':
                $times = 2;
                break;
            case 't.i.d':
                $times = 3;
                break;
            case 'q.i.d':
                $times = 4;
                break;
            default:
                $times = 1;

            return $prescription->take * $times;
        }
    }   
}
