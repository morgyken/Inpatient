<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inpatient\Entities\AdmissionType
 *
 * @property int $id
 * @property string $name
 * @property float $deposit
 * @property string $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\AdmissionType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\AdmissionType whereDeposit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\AdmissionType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\AdmissionType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\AdmissionType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\AdmissionType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AdmissionType extends Model
{
    protected $fillable = [
    	'name', 'description', 'deposit'
    ];

    protected $table = "inpatient_admission_types";

    /*
    * Accessor for the name column - Sets the name to title case
    */
    public function getNameAttribute($value)
    {
        return ucwords($value);
    }
}
