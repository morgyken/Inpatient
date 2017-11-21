<?php

namespace Ignite\Inpatient\Http\Controllers\Evaluation;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Ignite\Inpatient\Library\Interfaces\EvaluationInterface;

class PressureController extends Controller implements EvaluationInterface
{
    /*
    * Defien the view that this class should return
    */
    protected $view = "inpatient::admissions.evaluation.pressure";

    /*
    * Returns a view to be displayed
    */
    public function getData($admission)
    {
        return [
            'admission' => $admission,
            'patient' => $admission->patient,
            'active' => 'pressure',



            'items' => 'this is an item'
        ];
    }

    /*
    * Return the view 
    */
    public function getView()
    {
        return $this->view;
    }
}
