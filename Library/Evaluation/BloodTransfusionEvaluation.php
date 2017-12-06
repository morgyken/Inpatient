<?php
namespace Ignite\Inpatient\Library\Evaluation;

use Ignite\Evaluation\Entities\Visit;
use Ignite\Inpatient\Library\Interfaces\EvaluationInterface;
use Ignite\Inpatient\Entities\BloodTransfusion;

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
        $transfusions = BloodTransfusion::where('visit_id', $this->visit->id)->get();

        return compact('transfusions');
    }

    /*
     * Save the data to the database
    */
    public function persist()
    {
        $record = request()->except('_token');

        BloodTransfusion::create($record);
    }
}