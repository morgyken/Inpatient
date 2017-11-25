<?php
namespace Ignite\Inpatient\Library\Evaluation;

use Ignite\Inpatient\Library\Traits\PrescriptionsTrait;
use Ignite\Inpatient\Library\Interfaces\EvaluationInterface;

class PrescriptionsEvaluation implements EvaluationInterface
{
    use PrescriptionsTrait;

    /*
    * Method must be defined, gets the prescriptions
    */
    public function data($visit)
    {
        $prescriptions = $visit->admission->prescriptions->map(function($prescription){
            
                            return $this->transform($prescription);
            
                        });

        return compact('prescriptions');
    }

    /*
    * Makes the data more friendly to a datatable
    */
    public function table($visit)
    {
        $data =  $this->data($visit)['prescriptions']->map(function($prescription){
            
            return [
                $prescription['drug'],
                $prescription['dose'],
                $prescription['prescribed'],
                $prescription['dispensed'],
                $prescription['remaining'],
                0, 0
            ];

        })->toArray();

        return compact('data');
    }

    /*
    * Saves the required item into the database
    */
    public function persist()
    {
        dd(request()->all());


        // if (empty($this->request->drug)) {
        //     return false;
        // }
        // $cost = get_price_drug(Visit::find($this->visit), InventoryProducts::find($this->request->drug));
        // $this->input['user'] = $this->user;
        // $prescription = Prescriptions::create(array_except($this->input, 'quantity'));
        // $attributes = [
        //     'price' => $cost,
        //     'cost' => $cost * (int)$this->input['quantity'],
        //     'quantity' => (int)$this->input['quantity'],
        // ];
        // $prescription->payment()->create($attributes);
        // reload_payments();
        // $this->check_in_at('pharmacy');
        // return $prescription;
    }
}