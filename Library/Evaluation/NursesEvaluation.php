<?php

namespace Ignite\Inpatient\Library\Evaluation;

use Ignite\Inpatient\Library\Interfaces\EvaluationInterface;

class NursesEvaluation implements EvaluationInterface
{
    /*
    * Method must be defined, gets the prescriptions
    */
    public function data($visit)
    {
        $notes = $visit->notes;

        return compact('notes');
    }
}

