<?php
namespace Ignite\Inpatient\Library\Evaluation;

use Ignite\Inpatient\Library\Interfaces\EvaluationInterface;

class PatientVitalsEvaluation implements EvaluationInterface
{
    /*
    * Return the data that will be presented to the view on the charge sheet
    */
    public function data()
    {
        return [
            'charges' => ''
        ];
    }
}