<?php

namespace Ignite\Inpatient\Library\Evaluation;

use Ignite\Inpatient\Library\Interfaces\EvaluationInterface;

class DoctorsEvaluation implements EvaluationInterface
{
    /*
    * Method must be defined, gets the prescriptions
    */
    public function data($visit)
    {
        $notes = $visit->notes->map(function($note){

            dd($note);

        });

        return compact('notes');
    }
}

