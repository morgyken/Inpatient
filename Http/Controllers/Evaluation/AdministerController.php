<?php

namespace Ignite\Inpatient\Http\Controllers\Evaluation;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Ignite\Inpatient\Library\Traits\AdministerTrait;
use Ignite\Inpatient\Library\Interfaces\EvaluationInterface;
use Ignite\Inpatient\Entities\AdministerDrug;
use Carbon\Carbon;

class AdministerController extends Controller implements EvaluationInterface
{
    use AdministerTrait;

    /*
    * Define the view that this class should return
    */
    protected $view = "inpatient::admissions.evaluation.administer";

    /*
    * Returns a view to be displayed
    */
    public function getData($admission)
    {
        return [
            'admission' => $admission,
            'patient' => $admission->patient,
            'active' => 'administer',
            'dispensed' => $this->dispensed($admission)
        ];
    }

    /*
    * Return the view 
    */
    public function getView()
    {
        return $this->view;
    }

    /*
    * Administer a drug to the patient
    */
    public function administerDrugs()
    {
        $administer = AdministerDrug::findOrFail(request()->get('id'));

        $administer->administered = true;

        $administer->save();

        return response()->json([

            'id' => $administer->id,

            'time' => Carbon::parse($administer->updated_at)->format('h:i')
        ]);
    }
}
