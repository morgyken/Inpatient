<?php

namespace Ignite\Inpatient\Entities;

use Ignite\Users\Entities\User;
use Ignite\Reception\Entities\Patients;
use Ignite\Inpatient\Entities\Vitals;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inpatient\Entities\Admission
 *
 * @property int $id
 * @property int $patient_id
 * @property int|null $doctor_id
 * @property int $ward_id
 * @property int $bed_id
 * @property int $bedposition_id
 * @property float $cost
 * @property string|null $reason
 * @property string|null $external_doctor
 * @property int|null $visit_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Inpatient\Entities\Bed $bed
 * @property-read \Ignite\Users\Entities\User $doctor
 * @property-read \Ignite\Reception\Entities\Patients $patient
 * @property-read \Ignite\Inpatient\Entities\Visit|null $visit
 * @property-read \Ignite\Inpatient\Entities\Ward $ward
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Admission whereBedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Admission whereBedpositionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Admission whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Admission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Admission whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Admission whereExternalDoctor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Admission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Admission wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Admission whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Admission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Admission whereVisitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Admission whereWardId($value)
 * @mixin \Eloquent
 */
class Admission extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'ward_id',
        'bed_id',
        'cost',
        'reason',
        'external_doctor',
        'visit_id',
        'bedposition_id'
    ];

    protected $table = "admissions";

    public function patient()
    {
        return $this->belongsTo(Patients::class, "patient_id", "id");
    }

    public function doctor()
    {
        return $this->hasOne(User::class, 'id', 'doctor_id');
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class, "ward_id");
    }

    public function bed()
    {
        return $this->hasOne(Bed::class, "id", "bed_id");
    }

    public function visit()
    {
        return $this->belongsTo(Visit::class, "visit_id", "id");
    }

    public function vitals(){
         return $this->hasMany(Vitals::class);
    }
}
