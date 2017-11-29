<?php

namespace Ignite\Inpatient\Library\Evaluation;

use Ignite\Evaluation\Entities\Prescriptions;
use Ignite\Evaluation\Entities\Visit;
use Ignite\Inpatient\Library\Traits\PrescriptionsTrait;
use Ignite\Inpatient\Library\Interfaces\ChargesInterface;
use Ignite\Inpatient\Library\Interfaces\EvaluationInterface;

class InvestigationsEvaluation implements EvaluationInterface
{
    protected $visit;

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
            'investigations' => ''
        ];
    }

    public function table()
    {
        return [1, 2, 3];
    }
}