<?php

namespace Ignite\Inpatient\Http\Controllers\Evaluation;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Ignite\Inpatient\Library\Interfaces\EvaluationInterface;
use Ignite\Evaluation\Entities\Prescriptions;
use Ignite\Inpatient\Library\Traits\PrescriptionsTrait;
use Ignite\Evaluation\Entities\Dispensing;
use Ignite\Evaluation\Entities\DispensingDetails;
use Ignite\Inventory\Entities\InventoryStock;
use Ignite\Inpatient\Entities\AdministerDrug;

class PrescriptionsController extends Controller implements EvaluationInterface
{
    use PrescriptionsTrait;
    /*
    * Defien the view that this class should return
    */
    protected $view = "inpatient::admissions.evaluation.prescriptions";

    /*
    * Returns a view to be displayed
    */
    public function getData($admission)
    {
        return [
            'admission' => $admission,
            'patient' => $admission->patient,
            'active' => 'prescriptions',
            'prescriptions' => $this->prescriptions($admission),
        ];
    }

    /*
    * Return the view 
    */
    public function getView()
    {
        return $this->view;
    }

    /*
    * Store prescription data into the database
    */
    public function store()
    {
        $fields = request()->all();

        return Prescriptions::create($fields);
    }

    /*
    * Get the transformed prescriptions and send them to the view - imporove code by moving to transformer class
    */
    public function prescriptions($admission)
    {
        return $admission->prescriptions->map(function($prescription){

            return $this->transform($prescription);

        });
    }

    /*
    *
    */

    /*
    * Dispense drugs from the 
    */
    public function dispense()
    {
        $quantities = request()->except(['_token', 'visit', 'user']);

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

        return redirect()->back()->with(['success' => 'Drug dispensed successfully']);
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