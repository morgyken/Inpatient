<?php
namespace Ignite\Inpatient\Repositories;

use Ignite\Inventory\Entities\InventoryStock;
use Ignite\Inventory\Entities\InventoryStockAdjustment;
use Ignite\Inpatient\Library\Traits\PrescriptionsTrait;
use Ignite\Evaluation\Entities\Prescriptions;
use Ignite\Evaluation\Entities\Dispensing;
use Ignite\Inpatient\Entities\ChargeSheet;
use Carbon\Carbon;
use Ignite\Evaluation\Entities\Facility;
use Ignite\Inpatient\Entities\AdministerDrug;
use Ignite\Inventory\Entities\StorePrescription;
use Ignite\Inventory\Entities\StoreProducts;

class PrescriptionRepository
{
    use PrescriptionsTrait;

    /*
    * Create a new record in prescription payment
    */
    public function find($prescription)
    {
        return Prescriptions::findOrFail($prescription);
    }


    /*
    * Get the rescriptions to present to the pharamsist
    */
    public function getPrescriptions($visit)
    {
        $facility = Facility::where('name', 'inpatient')->first();
        
        $prescriptions = $visit->prescriptions->filter(function($prescription) use($facility){

            return ($prescription->facility_id == $facility->id);

        });

        $ordered = $this->transformPrescriptions($prescriptions);

        $dispensed = $this->dispensedPrescriptions($prescriptions);

        return compact('ordered', 'dispensed');
    }

    /*
    *  Get the Ordered prescriptions in a format that we can easily display in the view
    */
    public function transformPrescriptions($prescriptions)
    {
        return $prescriptions->map(function($prescription){

            return $this->transform($prescription);

        });
    }

    /*
    *  Get the dispensed prescriptions in a format that we can easily display in the view
    */
    public function dispensedPrescriptions($prescriptions)
    {
        $dispensed = $prescriptions->filter(function($prescription){
            
            return  $prescription->dispensing->count() > 0;
            
        });

        return $this->transformPrescriptions($dispensed);
    }

    /*
    * Dispense drugs
    */
    public function dispenseDrugs($visitId)
    {
        $prescriptions = collect(request()->get('prescriptions'));

        $prescriptions = $prescriptions->filter(function($prescription){

            return isset($prescription['quantity']);

        });
        
        $dispenses = $prescriptions->filter(function($prescription, $key){

            return ($prescription['stopped'] != "stopped");

        })->map(function($prescription) use($visitId){   

            return [
                'visit' => $visitId,

                'user' => \Auth::user()->id,

                'prescription' => $prescription['id'],

                'amount' => $prescription['price'],

                'product' => $prescription['product'],

                'quantity' => $prescription['quantity'],

                'price' => $prescription['total'],
            ];

        })->each(function($dispense) use($visitId){

            $dispensing = collect($dispense)->only(['visit', 'user', 'prescription', 'amount'])->all();

            $details = collect($dispense)->only(['product', 'quantity', 'price'])->all();

            $dispensing = Dispensing::create($dispensing);

            $dispensing->details()->create($details);

            $total = $details['quantity'] * $details['price'];

            $this->adjustStock($dispense['product'], $dispense['quantity']);

            $this->addToChargeSheet($dispensing->id, $total, $visitId);

            //remove prescribed, dispensed drugs from store
            $storePrescription = StorePrescription::where('prescription_id', $dispensing['prescription'])->first();

            $storeId = $storePrescription->store_id;

            $storeProducts = StoreProducts::where('store_id', $storeId)->where('product_id', $details['product'])->first();

            $storeProducts->quantity = $storeProducts->quantity - $details['quantity'];

            $storePrescription->dispensed = $storePrescription->dispensed + $details['quantity'];

            $storeProducts->save();

            $storePrescription->save();
            
        });
    }

    /*
    *  Add the details to a charge sheet
    */
    private function addToChargeSheet($dispensing, $total, $visitId)
    {
        ChargeSheet::create([

            'dispensing_id' => $dispensing,

            'price' => $total,

            'visit_id' => $visitId,
        ]);
    }

    /*
    * Remove the items from the store
    */
    public function adjustStock($productId, $quantity)
    {
        $stock = InventoryStock::where('product', $productId)->first();

        $stock->quantity = $stock->quantity - $quantity;

        $stock->save();
    }
}