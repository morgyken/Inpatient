<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;
use Ignite\Users\Entities\User;
use Ignite\Inpatient\Entities\Admission;

/**
 * Ignite\Inpatient\Entities\Vitals
 *
 * @property int $id
 * @property int $visit_id
 * @property int $admission_id
 * @property float|null $weight
 * @property float|null $height
 * @property string $bp_systolic
 * @property string $bp_diastolic
 * @property string $pulse
 * @property string $respiration
 * @property string $temperature
 * @property string $temperature_location
 * @property float $oxygen
 * @property float|null $waist
 * @property float|null $hip
 * @property string|null $blood_sugar
 * @property string $blood_sugar_units
 * @property string|null $allergies
 * @property string|null $chronic_illnesses
 * @property int $user_id
 * @property string $date_recorded
 * @property string $time_recorded
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Inpatient\Entities\Admission $admissions
 * @property-read \Ignite\Users\Entities\User $user
 * @property-read \Ignite\Inpatient\Entities\Visit $visits
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Vitals whereAdmissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Vitals whereAllergies($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Vitals whereBloodSugar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Vitals whereBloodSugarUnits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Vitals whereBpDiastolic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Vitals whereBpSystolic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Vitals whereChronicIllnesses($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Vitals whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Vitals whereDateRecorded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Vitals whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Vitals whereHip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Vitals whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Vitals whereOxygen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Vitals wherePulse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Vitals whereRespiration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Vitals whereTemperature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Vitals whereTemperatureLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Vitals whereTimeRecorded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Vitals whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Vitals whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Vitals whereVisitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Vitals whereWaist($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Vitals whereWeight($value)
 * @mixin \Eloquent
 */
class Vitals extends Model {

    public $table = 'inpatient_vitals';

    public function visits() {
        return $this->belongsTo(Visit::class, 'visit_id');
    }

    public function admissions() {
        return $this->belongsTo(Admission::class, 'admission_id');
    }

    public function user(){
    	return $this->hasOne(User::class, 'id', 'user_id');
    }

}
