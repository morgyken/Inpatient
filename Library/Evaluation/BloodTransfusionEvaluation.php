<?php
namespace Ignite\Inpatient\Library\Evaluation;

use Ignite\Evaluation\Entities\Visit;

use Ignite\Inpatient\Library\Interfaces\EvaluationInterface;

class BloodTransfusionEvaluation implements EvaluationInterface
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
    * Return the data that will be presented to the view on the charge sheet
    */
    public function data()
    {
        return [

        ];
    }
}