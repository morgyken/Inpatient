<?php
namespace Ignite\Inpatient\Library\Evaluation;

use Ignite\Inventory\Entities\InventoryProducts;
use Ignite\Inpatient\Library\Interfaces\EvaluationInterface;

class ConsumablesEvaluation implements EvaluationInterface
{
    /*
    * Return the data that will be presented to the view on the charge sheet
    */
    public function data($visit)
    {
        return [
            'consumables' => $this->getConsumables()
        ];
    }

    /*
    * These will go in a trait later
    **/
    public function getConsumables()
    {
        return InventoryProducts::where('consumable', '1')->get();
    }
}