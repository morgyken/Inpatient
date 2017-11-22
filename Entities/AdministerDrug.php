<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;
use Ignite\Evaluation\Entities\Patients;

class AdministerDrug extends Model
{
    protected $fillable = [
        'prescription_id', 'administered'
    ];

    protected $table = "inpatient_administer_drugs";

    /*
    * Relationship between administering a drug and the drug itself
    */
    // public function prescription()
    // {
    //     return $this->belongsTo();
    // }
}
