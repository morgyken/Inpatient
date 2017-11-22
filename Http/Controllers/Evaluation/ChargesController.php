<?php

namespace Ignite\Inpatient\Http\Controllers\Evaluation;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Ignite\Inpatient\Library\Interfaces\EvaluationInterface;

class ChargesController extends Controller implements EvaluationInterface
{
    /*
    * Define the view that this class should return
    */
    protected $view = "inpatient::admissions.evaluation.charges";

    /*
    * Returns a view to be displayed
    */
    public function getData($admission)
    {
        return [
            'admission' => $admission,
            'patient' => $admission->patient,
            'active' => 'charges',
            'charges' => $this->charges($admission)
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
    * Get the general charges during admission of the patient
    */
    public function general($admission)
    {
        //get charges for deposit
        $patient = $admission->patient;

        $patient->with(['admissionRequest']);
        
        dd($admission->patient->load(['admissionRequest']));

        // ->admissionType
    }

    /*
    * Gets the charge of a particular object from their controller
    */
    public function charges($admission)
    {
        // $depositCharges = 
        return [
            'general' => $this->general($admission)
        ];
    }
}
