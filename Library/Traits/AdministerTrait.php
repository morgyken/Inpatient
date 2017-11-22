<?php

namespace Ignite\Inpatient\Library\Traits;

use Carbon\Carbon;

trait AdministerTrait
{
    /*
    * Get the drugs dispensed in order to be administered
    */
    public function dispensed($admission)
    {
        return $admission->prescriptions->map(function($prescription){

            return [

                'id' => $prescription->id,
    
                'drug' => $prescription->drugs->name,
                
                'administer' => $this->administer($prescription)

            ];

        });
    }

    public function administer($prescription)
    {
        $administers = $prescription->administered->filter(function($administer){

            return Carbon::parse($administer->created_at)->isToday();
            
        });

        return $administers->map(function($administer){

            $label = $administer->administered ? Carbon::parse($administer->updated_at)->format('h:i') : 'give';

            return [
                'id' => $administer->id,

                'administered' => (boolean) $administer->administered,

                'label' => $label
            ];

        });
    }
}