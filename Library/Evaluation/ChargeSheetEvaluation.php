<?php
namespace Ignite\Inpatient\Library\Evaluation;

use Ignite\Evaluation\Entities\Prescriptions;
use Ignite\Inpatient\Library\Traits\PrescriptionsTrait;
use Ignite\Inpatient\Library\Interfaces\ChargesInterface;
use Ignite\Inpatient\Library\Interfaces\EvaluationInterface;

class ChargeSheetEvaluation implements EvaluationInterface
{
    /*
    * Return the data that will be presented to the view on the charge sheet
    */
    public function data($visit)
    {
        return [
            'charges' => ''
        ];
    }
}