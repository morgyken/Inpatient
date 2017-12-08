<?php

namespace Ignite\Inpatient\Entities;

use Ignite\Evaluation\Entities\Patients;
use Ignite\Evaluation\Entities\Prescriptions;
use Illuminate\Database\Eloquent\Model;

class AdministerDrug extends Model
{
    protected $fillable = [
        'prescription_id', 'administered', 'user_id'
    ];

    protected $table = "inpatient_administer_drugs";

    /*
    * Relationship between a dispensed record and the administer trail
    */
    public function prescription()
    {
        $this->belongsTo(Prescriptions::class, 'prescription_id');
    }
}
