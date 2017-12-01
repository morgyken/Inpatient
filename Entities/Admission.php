<?php

namespace Ignite\Inpatient\Entities;

use Ignite\Users\Entities\User;
use Ignite\Reception\Entities\Patients;
use Ignite\Inpatient\Entities\Vitals;
use Ignite\Inpatient\Entities\WardAssigned;
use Ignite\Inpatient\Entities\RequestDischarge;
use Ignite\Evaluation\Entities\Prescriptions;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inpatient\Entities\Admission
 *
 * @property int $id
 * @property int $patient_id
 * @property int|null $doctor_id
 * @property int $ward_id
 * @property int $bed_id
 * @property float|null $cost
 * @property string|null $reason
 * @property string|null $external_doctor
 * @property int $visit_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Inpatient\Entities\Bed $bed
 * @property-read \Ignite\Users\Entities\User $doctor
 * @property-read mixed $discharged
 * @property-read mixed $has_discharge_request
 * @property-read \Ignite\Reception\Entities\Patients $patient
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Evaluation\Entities\Prescriptions[] $prescriptions
 * @property-read \Ignite\Inpatient\Entities\Visit $visit
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Inpatient\Entities\Vitals[] $vitals
 * @property-read \Ignite\Inpatient\Entities\Ward $ward
 * @property-read \Ignite\Inpatient\Entities\WardAssigned $wardAssigned
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Admission whereBedId($value)
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

    protected $table = "inpatient_admissions";

    protected $with = ['patient', 'doctor', 'ward', 'bed'];

    public function getDischargedAttribute(){
        return ($this->is_discharged == 0) ? false : true ;
    }

    public function getHasDischargeRequestAttribute(){
        return (RequestDischarge::where('visit_id',$this->visit_id)->count() > 0) ? true : false;
    }

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

     public function wardAssigned()
    {
        return $this->belongsTo(WardAssigned::class, "id", 'admission_id');
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

    /*
    * Relationship between an admission and the prescriptions defined
    */
    public function prescriptions()
    {
        return $this->hasMany(Prescriptions::class);
    }

    
}
