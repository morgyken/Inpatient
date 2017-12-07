<?php

namespace Ignite\Inpatient\Library\Traits;

use Ignite\Evaluation\Entities\Visit;
use Ignite\Evaluation\Entities\DispensingDetails;
use Ignite\Inventory\Entities\InventoryProducts;

trait DrugsTrait
{
    /*
    * Get the price of the drug - uses the visit to determine if patient is insured
    */
    public function getProductPrice($data)
    {
        $visit = Visit::findOrFail($data['visit']);

        $product = InventoryProducts::findOrFail($data['drug']);

        return count($visit->scheme) > 0 ? $product->insurance_p : $product->cash_price;
    }
}
