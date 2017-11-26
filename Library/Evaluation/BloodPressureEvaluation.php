<?php
namespace Ignite\Inpatient\Library\Evaluation;

use Ignite\Evaluation\Entities\Visit;
use Ignite\Inpatient\Entities\BloodPressure;
use Ignite\Inpatient\Library\Interfaces\EvaluationInterface;

class BloodPressureEvaluation implements EvaluationInterface
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
        $patientId = $this->visit->patients->id;

        $admissionId = $this->visit->admission->id;

        $bpChart = $this->getCharts($patientId, $admissionId);

        return compact('bpChart');
    }

    /*
    * Get the charts
    */
    public function getCharts($patient, $admission)
    {
        $bp = BloodPressure::wherePatientId($patient)->whereAdmissionId($admission)->get();
        return \Charts::multi('line', 'highcharts')
            ->title('Blood Pressure Chart')
            ->labels($bp->pluck('date'))
            ->dataset('Blood Pressure', $bp->pluck('value'))
            ->dataset('Diastolic', $bp->pluck('diastolic'))
            ->template('material')
            ->container('bp_chart')
            ->width(0)
            ->height(0);
    }
}