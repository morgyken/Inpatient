<?php
namespace Ignite\Inpatient\Library\Evaluation;

use Ignite\Evaluation\Entities\Visit;
use Ignite\Inpatient\Entities\ChargeSheet;
use Ignite\Inpatient\Library\Interfaces\EvaluationInterface;

use Carbon\Carbon;

class ChargeSheetEvaluation implements EvaluationInterface
{
    protected $visit; 
    
    /*
    * Initialize the visit property
    */
    public function __construct(Visit $visit)
    {
        $this->visit = $visit;
    }

    /*
    * Return the data that will be presented to the view on the charge sheet
    */
    public function data()
    {
        return [
            'wards' => $this->wards(),

            'charges' => $this->charges(),

            'consumables' => $this->consumables(),

            'prescriptions' => $this->prescriptions(),

            'doctor_procedures' => $this->procedures('doctor'),

            'nurse_procedures' => $this->procedures('nurse')
        ];
    }

    /*
    * Ward Charges
    */
    public function wards()
    {
        $charges = $this->visit->chargeSheet->load('ward');

        $ward = $this->visit->admission->ward;

        $days = $charges->filter(function($charge){

            return $charge->ward_id;

        })->count();

        $name = $ward->name;

        $cost = $this->visit->patients->schemes ? $ward->insurance_cost : $ward->cash_cost;;

        $price = $days * $cost;

        return compact('name', 'days', 'cost', 'price');
    }

    /*
    * One off & recurring charges
    */
    public function charges()
    {
        $charges = $this->visit->chargeSheet->load('charge');

        $charges = $charges->filter(function($charge){
            
            return $charge->charge_id;

        });

        foreach($charges as $charge)
        {
            $charge->name = $charge->charge->name;
        }   

        return $charges;
    }

    /*
    * Consumable charges
    */
    public function consumables()
    {
        $charges = $this->visit->chargeSheet->load('consumable');

        $consumableCharges = $charges->filter(function($charge){
            
            return $charge->consumable_id;

        });

        $charges = $consumableCharges->map(function($charge){

            $consumable = $charge->consumable;

            $product = $consumable->product;
            
            return [
                'name' => $product->name, 
                'units' => $consumable->quantity, 
                'cost' => $consumable->price, 
                'price' => $consumable->amount,
                'used_on' => Carbon::parse($consumable->created_at)->toDayDateTimeString(),  
            ];
        
        });

        $charges = $charges->groupBy('name')->map(function($charge, $key){
            
            $units = $charge->pluck('units')->sum();
            $cost = $charge->pluck('cost')->first();

            return [
                'name' => $charge->pluck('name')->first(),
                'units' => $units, 
                'cost' =>  $cost, 
                'price' => $units * $cost, 
            ];
        });

        $charges['total'] = $charges->pluck('price')->sum();
        
        return $charges;
    }

    /*
    * Prescription Charges
    */
    public function prescriptions()
    {
        $charges = $this->visit->chargeSheet->load('dispense');

        $prescriptionCharges = $charges->filter(function($charge){
            
            return $charge->dispensing_id;

        });

        $charges = $prescriptionCharges->map(function($charge){

            $dispense = $charge->dispense;

            $details = $dispense->details->first();

            $prescription = $dispense->prescriptions;

            $drug = $prescription->drugs;

            $cost = $this->visit->patients->schemes ? $drug->insurance_p : $drug->cash_p;

            return [
                'name' => $drug->name, 
                'units' => $details->quantity, 
                'cost' => $cost, 
                'price' => $details->price,
                'dispensed' => Carbon::parse($dispense->created_at)->toDayDateTimeString(),  
            ];

        });

        $charges = $charges->groupBy('name')->map(function($charge, $key){

            $units = $charge->pluck('units')->sum();
            $cost = $charge->pluck('cost')->first();

            return [
                'name' => $charge->pluck('name')->first(),
                'units' => $units, 
                'cost' =>  $cost, 
                'price' => $units * $cost, 
            ];
        });

        $charges['total'] = $charges->pluck('price')->sum();

        return $charges;
    }

    /*
    * Get Procedures
    */
    public function procedures($procedureType)
    {
        
    }
}