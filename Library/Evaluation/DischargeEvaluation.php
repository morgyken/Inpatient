<?php

namespace Ignite\Inpatient\Library\Evaluation;

use Ignite\Evaluation\Entities\Visit;

use Ignite\Inpatient\Library\Interfaces\EvaluationInterface;

use Ignite\Inpatient\Entities\InpatientDoctorNotes;
use Ignite\Inpatient\Entities\DischargeType;
use Ignite\Inpatient\Entities\DischargeRequest;

class DischargeEvaluation implements EvaluationInterface
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
        $dichargeTypes = DischargeType::all();

        // $this->visit->load('discharge');

        return compact('dichargeTypes');
    }

    /*
    * Persist the doctors notes into the database
    */
    public function persist()
    {
        $record = request()->all();

        $record['visit_id'] = $this->visit->id;

        return DischargeRequest::create($record);
    }
}

