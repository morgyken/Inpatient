<?php

namespace Ignite\Inpatient\Entities;

use Ignite\Evaluation\Entities\Patients;
use Ignite\Evaluation\Entities\Prescriptions;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inpatient\Entities\AdministerDrug
 *
 * @property int $id
 * @property int $prescription_id
 * @property int $administered
 * @property int $user_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\AdministerDrug whereAdministered($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\AdministerDrug whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\AdministerDrug whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\AdministerDrug wherePrescriptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\AdministerDrug whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\AdministerDrug whereUserId($value)
 * @mixin \Eloquent
 */
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
