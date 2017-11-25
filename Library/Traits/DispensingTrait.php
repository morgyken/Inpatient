<?php

namespace Ignite\Inpatient\Library\Traits;

use Ignite\Evaluation\Entities\Dispensing;
use Ignite\Inventory\Entities\InventoryStock;
use Ignite\Inpatient\Entities\AdministerDrug;
use Ignite\Evaluation\Entities\Prescriptions;
use Ignite\Evaluation\Entities\DispensingDetails;

trait DispensingTrait
{
    /*
    * Dispense drugs from the pharmacy. Take to Dispensing Trait
    */
    public function dispense($quanitites)
    {
        //consider using an event for this
        foreach($quantities as $prescription => $quantity)
        {   
            $pres = Prescriptions::findOrFail($prescription);

            $product = $pres->drug;

            $dispensing = Dispensing::create([
                'visit' => request()->get('visit'),

                'user' => request()->get('user'),

                'prescription' => $prescription,
            ]);

            DispensingDetails::create([

                'batch' => $dispensing->id,

                'quantity' => $quantity,

                'product' => $product,

            ]);

            $this->administerSetUp($pres);

            $stock = InventoryStock::where('product', $product)->first();

            $stock->quantity = $stock->quantity - $quantity;

            $stock->save();
        }
    }

        /*
    * Set up a prescription for administering
    */
    public function administerSetUp($prescription)
    {
        for($start = 0; $start < $this->administerRecords($prescription); $start++)
        {
            AdministerDrug::create([
                'prescription_id' => $prescription->id
            ]);
        }
    }

    /*
    * Shows the amount of drugs to dispense
    */
    public function administerRecords($prescription)
    {
        $method = trim(mconfig('evaluation.options.prescription_method.' . $prescription->method));

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

        return $times;
    }
}