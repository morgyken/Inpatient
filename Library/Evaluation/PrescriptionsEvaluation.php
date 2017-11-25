<?php
namespace Ignite\Inpatient\Library\Evaluation;

use Ignite\Inpatient\Library\Traits\PrescriptionsTrait;
use Ignite\Inpatient\Library\Interfaces\EvaluationInterface;

class PrescriptionsEvaluation implements EvaluationInterface
{
    use PrescriptionsTrait;

    /*
    * Method must be defined, gets the prescriptions
    */
    public function data($visit)
    {
        $prescriptions = $visit->admission->prescriptions->map(function($prescription){
            
                            return $this->transform($prescription);
            
                        });

        return compact('prescriptions');
    }
}