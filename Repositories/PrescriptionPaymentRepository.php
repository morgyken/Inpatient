<?php
namespace Ignite\Inpatient\Repositories;

use Ignite\Evaluation\Entities\PrescriptionPayment;
use Carbon\Carbon;

class PrescriptionPaymentRepository
{
    /*
    * Create a new record in prescription payment
    */
    public function create($prescription, $quantity)
    {
        if(count($prescription->admission->patient->schemes) == 0)
        {
            dd($prescription->drugs->prices);
        }

        
        // $prescription->drugs->stocks->quantity
        // dd($prescription);
        // $prescriptionPayment = PrescriptionPayment::create([
            
        //     'prescription_id' => $prescription->id,

        //     'price' => 

        //     'cost' => 

        //     'quantity' => $quantity
        // ])

        // PrescriptionPayment

        // precsritpion_id, price, discount, cost, quantity, 

        //create the prescription payment

        //remove the discharged amount of drugs from the stock
    }
}