<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inpatient\Entities\BloodPressure
 *
 * @property int $id
 * @property int $value
 * @property int $admission_id
 * @property int $patient_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read mixed $date
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\BloodPressure whereAdmissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\BloodPressure whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\BloodPressure whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\BloodPressure wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\BloodPressure whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\BloodPressure whereValue($value)
 * @mixin \Eloquent
 */
class BloodPressure extends Model
{
    protected $guarded = [];
    protected $table = 'inpatient_blood_pressures';

    public function getDateAttribute()
    {
        return $this->created_at->format('d.m.Y H:i');
    }
}
