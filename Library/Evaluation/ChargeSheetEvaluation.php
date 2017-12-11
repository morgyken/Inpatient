<?php

namespace Ignite\Inpatient\Library\Evaluation;

use Carbon\Carbon;
use Ignite\Evaluation\Entities\Investigations;
use Ignite\Evaluation\Entities\Visit;
use Ignite\Inpatient\Library\Interfaces\EvaluationInterface;
use Illuminate\Support\Collection;

class ChargeSheetEvaluation implements EvaluationInterface
{
    /**
     * @var Visit
     */
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

            'investigations' => $this->investigations(),

            'procedures' => $this->procedures()
        ];
    }

    /*
    * Ward Charges
    */
    public function wards()
    {
        $charges = $this->visit->chargeSheet->load('ward');

        $ward = $this->visit->admission->ward;

        $days = $charges->filter(function ($charge) {

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

        $charges = $charges->filter(function ($charge) {

            return $charge->charge_id;

        })->groupBy('charge_id')->map(function($charge){

            $name = $charge->first()->charge->name;
            $units = $charge->count();
            $cost = $charge->pluck('price')->first();
            $total = $units * $cost;

            return [
                'name' => $name, 
                'units' => $units, 
                'cost' => $cost, 
                'total' => $total, 
            ];

        });

        $charges['total'] = $charges->pluck('total')->sum();
        
        return $charges;
    }

    /*
    * Consumable charges
    */
    public function consumables()
    {
        $charges = $this->visit->chargeSheet->load('consumable');

        $consumableCharges = $charges->filter(function ($charge) {

            return $charge->consumable_id;

        });

        $charges = $consumableCharges->map(function ($charge) {

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

        $charges = $charges->groupBy('name')->map(function ($charge, $key) {

            $units = $charge->pluck('units')->sum();
            $cost = $charge->pluck('cost')->first();

            return [
                'name' => $charge->pluck('name')->first(),
                'units' => $units,
                'cost' => $cost,
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

        $prescriptionCharges = $charges->filter(function ($charge) {

            return $charge->dispensing_id;

        });

        $charges = $prescriptionCharges->map(function ($charge) {

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

        $charges = $charges->groupBy('name')->map(function ($charge, $key) {

            $units = $charge->pluck('units')->sum();
            $cost = $charge->pluck('cost')->first();

            return [
                'name' => $charge->pluck('name')->first(),
                'units' => $units,
                'cost' => $cost,
                'price' => $units * $cost,
            ];
        });

        $charges['total'] = $charges->pluck('price')->sum();

        return $charges;
    }

    /*
    * Get Investigations
    */
    public function investigations()
    {
        $charges = $this->visit->chargeSheet->load('investigation');

        $charges = $charges->filter(function ($charge) {

            return ($charge->investigation_id && strpos($charge->investigation->type, 'inpatient') !== false);
        });
        $diagnostics = $this->getInvestigations($charges, 'diagnostics');

        $laboratory = $this->getInvestigations($charges, 'laboratory');

        $radiology = $this->getInvestigations($charges, 'radiology');

        $total = $radiology['total'] + $laboratory['total'] + $diagnostics['total'];

        return compact('diagnostics', 'laboratory', 'radiology', 'total');
    }

    /*
    * GetProcedures
    */
    public function procedures()
    {
        $charges = $this->visit->chargeSheet->load('investigation');

        $charges = $charges->filter(function ($charge) {

            return ($charge->investigation_id && strpos($charge->investigation->type, 'inpatient') !== false);
        });

        $doctor = $this->getInvestigations($charges, 'treatment');

        $nursing = $this->getInvestigations($charges, 'nursing');

        $total = $doctor['total'] + $nursing['total'];
        return compact('doctor', 'nursing', 'total');
    }

    /**
     * @param Collection $charges
     * @param string $type
     * @return mixed
     */
    public function getInvestigations($charges, $type)
    {
        $charges = $charges->filter(function ($charge) use ($type) {

            return (strpos($charge->investigation->type, $type) !== false);

        });
        $charges = $charges->map(function ($charge) {
            /** @var Investigations $investigation */
            $investigation = $charge->investigation;

            $procedure = $investigation->procedures;
            $paid = $investigation->is_paid || $investigation->invoiced;
            return [
                'name' => $procedure->name,
                'units' => $investigation->quantity,
                'cost' => $investigation->price,
                'price' => $investigation->amount,
                'paid' => $paid,
                'payment_label' => payment_label($paid, !$this->visit->is_cash)
            ];

        });
        $charges = $charges->groupBy('name')->map(function ($charge, $key) {
            $units = $charge->pluck('units')->sum();
            $cost = $charge->pluck('cost')->first();
            return [
                'name' => $charge->pluck('name')->first(),
                'units' => $units,
                'cost' => $cost,
                'price' => $units * $cost,
                'paid' => $charge->pluck('paid')->first(),
                'payment_label' => $charge->pluck('payment_label')->first(),
            ];
        });

        $charges['total'] = $charges->pluck('price')->sum();
        return $charges;
    }
}