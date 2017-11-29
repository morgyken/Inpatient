<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;
use Ignite\Evaluation\Entities\Patients;

/**
 * Ignite\Inpatient\Entities\AdministerDrug
 *
 * @property int $id
 * @property int $prescription_id
 * @property int $administered
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\AdministerDrug whereAdministered($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\AdministerDrug whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\AdministerDrug whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\AdministerDrug wherePrescriptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\AdministerDrug whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
