<?php

namespace Ignite\Inpatient\Library\Interfaces;

interface EvaluationInterface
{
    /*** Move these to a template eventually ***/
    public function getData($admission);

    public function getView();

    /*
    * Store the details of the evaluation
    */
    // public function store($admission);

}