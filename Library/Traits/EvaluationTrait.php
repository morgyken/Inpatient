<?php

namespace Ignite\Inpatient\Library\Traits;

use Ignite\Inpatient\Library\Interfaces\EvaluationInterface;

//Consider renaming this the Evaluation Trait ---> and generally changing it into the evaluation controller :)
trait EvaluationTrait
{
    /*
    * Handles fetching of the 
    */
    public function display($admission, EvaluationInterface $evaluationItem)
    {
        $view = $evaluationItem->getView();

        $data = $evaluationItem->getData($admission);

        return compact('view', 'data');
    }

    /*
    * Manage the storage of evaluation items
    */
    public function persist($admission, EvaluationInterface $evaluationItem)
    {
        return $evaluationItem->store($admission);
    } 

    /*
    * Gets the evaluation object that is required, given the namespace
    */
    private function getEvaluationObject($evaluationItem)
    {
        $className = ucwords($evaluationItem) . "Controller";

        return "Ignite\Inpatient\Http\Controllers\Evaluation\\$className";
    }
}