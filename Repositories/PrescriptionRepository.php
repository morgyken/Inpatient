<?php
namespace Ignite\Inpatient\Repositories;

use Ignite\Evaluation\Entities\Prescriptions;
use Carbon\Carbon;

class PrescriptionRepository
{
    /*
    * Create a new record in prescription payment
    */
    public function find($prescription)
    {
        return Prescriptions::findOrFail($prescription);
    }

    
}