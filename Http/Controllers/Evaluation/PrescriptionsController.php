<?php

namespace Ignite\Inpatient\Http\Controllers\Evaluation;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Ignite\Inpatient\Library\Interfaces\EvaluationInterface;
use Ignite\Evaluation\Entities\Prescriptions;
use Ignite\Inpatient\Library\Traits\PrescriptionsTrait;

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
            'prescriptions' => $this->prescriptions($admission)
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
    * Dispense drugs To the cashier
    */
    public function dispense()
    {

    }
}