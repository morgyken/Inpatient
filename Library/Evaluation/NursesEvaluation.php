<?php

namespace Ignite\Inpatient\Library\Evaluation;

use Ignite\Evaluation\Entities\Visit;

use Ignite\Inpatient\Library\Interfaces\EvaluationInterface;

class NursesEvaluation implements EvaluationInterface
{
    protected $visit; 
    
    /*
    * Initialize the visit property
    */
    public function __construct(Visit $visit)
    {
        $this->visit = $visit;
    }


    /*
    * Method must be defined, gets the prescriptions
    */
    public function data()
    {
        $notes = $this->visit->notes;

        return compact('notes');
    }
}

