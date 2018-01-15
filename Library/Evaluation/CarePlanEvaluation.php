<?php
namespace Ignite\Inpatient\Library\Evaluation;

use Ignite\Evaluation\Entities\Visit;
use Ignite\Inpatient\Entities\NursingCarePlan;
use Ignite\Inpatient\Library\Interfaces\EvaluationInterface;

class CarePlanEvaluation implements EvaluationInterface
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
        $plan = null;

        if(request()->has('plan'))
        {
            $planId = request('plan');

            $plan = NursingCarePlan::find($planId);
        }

        $plans = NursingCarePlan::where('visit_id', $this->visit->id)->get();

        return compact('plans', 'plan');
    }

    /*
    * Post Blood pressure data
    */
    public function persist()
    {
        if(request()->has('plan_id'))
        {
            $record = request()->except(['_token', 'plan_id']);

            NursingCarePlan::find(request('plan_id'))->update($record);
        }
        else
        {
            $record = request()->except('_token');

            NursingCarePlan::create($record);
        }
    }
}