<?php

namespace Ignite\Inpatient\Library\Traits;

trait PrescriptionsTrait
{
    public function transform($prescription)
    {
        return [
            'id' => $prescription->id,

            'drug_id' => $prescription->drug,

            'drug' => $prescription->drugs->name,
            
            'dose' => $prescription->dose,
            
            'prescribed' => $prescription->quantity,

            'to_dispense' => $this->toDispense($prescription),

            'is_dispensed' => $prescription->payment
        ];
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
