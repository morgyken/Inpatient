<?php
namespace Ignite\Inpatient\Library\Evaluation;

use Ignite\Inpatient\Library\Interfaces\EvaluationInterface;

class ProceduresEvaluation implements EvaluationInterface
{
    /*
    * Method must be defined, gets the prescriptions
    */
    public function data($visit)
    {
        $procedures = [];

        return compact('procedures');
    }
}