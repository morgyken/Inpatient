<?php
namespace Ignite\Inpatient\Library\Evaluation;

use Ignite\Evaluation\Entities\Visit;
use Ignite\Inpatient\Entities\FluidBalance;
use Ignite\Inpatient\Library\Interfaces\EvaluationInterface;

class FluidBalanceEvaluation implements EvaluationInterface
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

    /*
    * Post Blood pressure data
    */
    public function persist()
    {
        
    }
}