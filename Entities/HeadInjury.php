<?php

namespace Ignite\Inpatient\Entities;

use Ignite\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inpatient\Entities\HeadInjury
 *
 * @property int $id
 * @property int $admission_id
 * @property int $visit_id
 * @property int $user_id
 * @property string|null $bp_systolic
 * @property string|null $bp_diastolic
 * @property string|null $pulse
 * @property string|null $respiration
 * @property string|null $temperature
 * @property array $conscious_status
 * @property array $pupil_status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Inpatient\Entities\Admission $admission
 * @property-read \Ignite\Users\Entities\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\HeadInjury whereAdmissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\HeadInjury whereBpDiastolic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\HeadInjury whereBpSystolic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\HeadInjury whereConsciousStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\HeadInjury whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\HeadInjury whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\HeadInjury wherePulse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\HeadInjury wherePupilStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\HeadInjury whereRespiration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\HeadInjury whereTemperature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\HeadInjury whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\HeadInjury whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\HeadInjury whereVisitId($value)
 * @mixin \Eloquent
 */
class HeadInjury extends Model
{

    protected $table = "inpatient_headinjury_and_craniotomy";

    public $casts = [
        'conscious_status' => 'array',
        'pupil_status' => 'array'
    ];

    public function admission(){
        return $this->belongsTo(Admission::class, "admission_id", "id");
    }

    public function user(){
        return $this->hasOne(User::class,'id', 'user_id', 'id');
    }

}
