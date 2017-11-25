<?php
namespace Ignite\Inpatient\Library;

use Ignite\Evaluation\Entities\Visit;

class Evaluator
{
    protected $active, $view, $data, $visit, $evaluation;

    /*
    * Configure the namespace for the evaluation libraries and views
    */
    protected $config = [

        'namespace' => "Ignite\Inpatient\Library\Evaluation",

        'view' => "inpatient::admissions.evaluation"

    ];

    /*
    * Initialise the basic properties in the class
    */
    public function __construct($visit, $key)
    {   
        $this->active = $key;

        $this->visit = Visit::findOrFail($visit);

        $this->setView($key);

        $this->setEvaluation($key);

        $this->setData();
    }

    /*
    * Sets the data that will be used within the evaluation object and return with getter
    * Evaluation object accesses its custom data via Decoration
    */
    public function setData()
    {
        $this->data = array_merge([

            'active' => $this->active,

            'visit' => $this->visit,

            'patient' => $this->visit->patients,

            'admission' => is_module_enabled('Inpatient') ? $this->visit->admission : false,

        ], $this->getEvaluation()->data($this->visit));
    }

    /*
    * Useful when we are sending an API call and data will be expected in a certain format 
    */
    public function getTable()
    {
        return $this->getEvaluation()->table($this->visit);
    }

    /*
    * Returns the data that the evaluator should display on its view
    */
    public function getData()
    {
        return $this->data;
    }

    /*
    * Sets the evaluation view as defined within the config namespace and return it using a getter
    */
    public function setView($key)
    {
        $this->view = "inpatient::admissions.evaluation.".$key;
    }

    public function getView()
    {
        return $this->view;
    }

    /*
    * Sets the evaluation class as defined within the config namespace and return it using a getter
    */
    public function setEvaluation($key)
    {
        $className = "";

        collect(explode("-", $key))->each(function($build) use(&$className){

            $className .= ucwords($build);

        });

        $this->evaluation = $this->config['namespace']."\\$className"."Evaluation";
    }

    public function getEvaluation()
    {
        return new $this->evaluation;
    }
}