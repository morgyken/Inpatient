<?php

namespace Ignite\Inpatient\Library\Evaluation;

use Ignite\Evaluation\Entities\Visit;

use Ignite\Inpatient\Library\Interfaces\EvaluationInterface;

use Ignite\Inpatient\Entities\InpatientDoctorNotes;

class DoctorsEvaluation implements EvaluationInterface
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
        return [];
    }

    /*
    * Persist the doctors notes into the database
    */
    public function persist()
    {
        dd(request()->all());
    }
}

