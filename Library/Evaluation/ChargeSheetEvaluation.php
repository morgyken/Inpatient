<?php
namespace Ignite\Inpatient\Library\Evaluation;

use Ignite\Evaluation\Entities\Visit;

use Ignite\Inpatient\Entities\ChargeSheet;

use Ignite\Inpatient\Library\Interfaces\EvaluationInterface;

class ChargeSheetEvaluation implements EvaluationInterface
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
        return [
            'ward' => $this->wardCharges(),

            'nurse' => $this->nurseCharges(),
        ];


        // $generalCharges = 

        // return [
        //     'charges' => ''
        // ];
    }

    /*
    * Ward Charges
    */
    public function wardCharges()
    {
        $this->visit->chargeSheet->load('wards');

        $charges = $this->visit->chargeSheet->filter(function($charge){

            return $charge->ward_id;

        });

        dd($charges);
        
        // ('', function($query){

        //     $wardCharges = $query->where('ward_id', '<>', '0')->get();

        //     dd($wardCharges);

        // });
        // $charges = ChargeSheet::where('ward_id', '<>', '0')->get();

        // return $charges->map(function($charge){

        //     dd($charge);

        //     return [



        //     ];

        // });
    }
}