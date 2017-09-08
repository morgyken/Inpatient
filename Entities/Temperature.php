<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inpatient\Entities\Temperature
 *
 * @property int $id
 * @property int|null $respiration
 * @property int|null $pulse
 * @property int|null $temperature
 * @property int|null $bowels
 * @property int|null $urine
 * @property int $admission_id
 * @property int $patient_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read mixed $date
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Temperature whereAdmissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Temperature whereBowels($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Temperature whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Temperature whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Temperature wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Temperature wherePulse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Temperature whereRespiration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Temperature whereTemperature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Temperature whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Temperature whereUrine($value)
 * @mixin \Eloquent
 */
class Temperature extends Model
{
    protected $guarded = [];
    protected $table = 'inpatient_temperatures';

    public function getDateAttribute()
    {
        return $this->created_at->format('d.m.Y H:i');
    }
}
