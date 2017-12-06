<?php
namespace Ignite\Inpatient\Library\Evaluation;

use Ignite\Inpatient\Entities\Vitals;
use Ignite\Evaluation\Entities\Visit;
use Ignite\Inpatient\Library\Interfaces\EvaluationInterface;

class PatientVitalsEvaluation implements EvaluationInterface
{
    protected $visit, $facility; 
    
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
        $vitals = Vitals::where('visit_id', $this->visit->id)->get();

        return compact('vitals');
    }

    /*
    * Save the patients vitals
    */
    public function persist()
    {
        return Vitals::create(request()->all());
    }

    /*
    * Present data to the table on vitals
    */
    public function table()
    {

    }
}