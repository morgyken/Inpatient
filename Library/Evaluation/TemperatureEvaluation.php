<?php
namespace Ignite\Inpatient\Library\Evaluation;

use Ignite\Evaluation\Entities\Visit;
use Ignite\Inpatient\Entities\Temperature;
use Ignite\Inpatient\Library\Interfaces\EvaluationInterface;

class TemperatureEvaluation implements EvaluationInterface
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

        $tempChart = $this->getTemperatureChart($patientId, $admissionId);

        return compact('tempChart');
    }

    /*
    * Get the charts
    */
    private function getTemperatureChart($patient, $admission)
    {
        $t = Temperature::wherePatientId($patient)->whereAdmissionId($admission)->get();
        return \Charts::create('line', 'highcharts')
            ->title('Temperature Chart')
            ->elementLabel('Temperature')
            ->labels($t->pluck('date'))
            ->values($t->pluck('temperature'))
            ->template('material')
            ->container('temp_chart')
            ->width(0)
            ->height(0);
        /* return \Charts::realtime(
             url('api/inpatient/v1/get/temperature'), 2000, 'line', 'highcharts')
             ->values($t->pluck('value'))
             ->labels($t->pluck('created_at'))
             ->responsive(false)->elementLabel('Temperature')
             ->height(300)
             ->width(0)
             ->title('Temperature')
             ->valueName('temperature');*/

    }
}