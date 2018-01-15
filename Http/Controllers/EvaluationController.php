<?php

namespace Ignite\Inpatient\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Ignite\Inpatient\Library\Evaluator;

class EvaluationController extends AdminBaseController
{
    /*
     * Displays a resource based on the evaluation key passed in the url
     */
    public function index($visit, $key)
    {
        $evaluator = new Evaluator($visit, $key);

        if(request()->ajax())
        {
            return response()->json($evaluator->getTable());
        }

        return view($evaluator->getView(), $evaluator->getData());
    }

    /*
     * Store a newly created evaluation item
     */
    public function store($visit, $key)
    {
        (new Evaluator($visit, $key))->getEvaluation()->persist();

        if(request()->ajax())
        {
            return response()->json([
                'data' => true
            ]);
        }

        return redirect()->back()->with(['success' => 'Action successfully completed']);
    }

    /*
    * Update an existing evaluation object
    */
    public function update($visit, $key)
    {
        (new Evaluator($visit, $key))->getEvaluation()->modify();
 
        if(request()->ajax())
        {
            return response()->json([
                 'data' => true
            ]);
        }
 
         return redirect()->back()->with(['success' => 'Action successfully completed']);
    }
}
