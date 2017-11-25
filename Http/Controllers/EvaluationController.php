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

        return view($evaluator->getView(), $evaluator->getData());
    }

    /*
     * Store a newly created evaluation item
     */
    public function store($visit, $key)
    {
        (new Evaluator($visit, $key))->getEvaluation()->persist(

            request()->all()

        );

        return redirect()->back()->with(['success' => 'Action successfully completed']);
    }

    /*
     * Dispense the drugs from the pharmacist - applicable for the Prescriptions Evalution Object only
     */
    public function dispense($visit, $key)
    {
        (new Evaluator($visit, $key))->getEvaluation()->dispense(
            
            request()->except(['_token', 'visit', 'user'])
            
        );

        return redirect()->back()->with(['success' => 'Drugs successfully dispensed']);
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('inpatient::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
