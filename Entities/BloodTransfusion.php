<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

use Ignite\Inpatient\Entities\Admission;
use Ignite\Inpatient\Entities\Visit;
use Ignite\Users\Entities\User;

/**
 * Ignite\Inpatient\Entities\BloodTransfusion
 *
 * @property int $id
 * @property int $admission_id
 * @property int $visit_id
 * @property int $user_id
 * @property int|null $bp_systolic
 * @property int|null $bp_diastolic
 * @property int|null $temperature
 * @property int|null $respiration
 * @property string|null $remarks
 * @property string $date_recorded
 * @property string $time_recorded
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Inpatient\Entities\Admission $admission
 * @property-read \Ignite\Users\Entities\User $user
 * @property-read \Ignite\Inpatient\Entities\Visit $visit
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\BloodTransfusion whereAdmissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\BloodTransfusion whereBpDiastolic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\BloodTransfusion whereBpSystolic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\BloodTransfusion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\BloodTransfusion whereDateRecorded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\BloodTransfusion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\BloodTransfusion whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\BloodTransfusion whereRespiration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\BloodTransfusion whereTemperature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\BloodTransfusion whereTimeRecorded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\BloodTransfusion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\BloodTransfusion whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\BloodTransfusion whereVisitId($value)
 * @mixin \Eloquent
 */
class BloodTransfusion extends Model
{
    public $table = 'inpatient_blood_transfusion';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function admission(){
        return $this->belongsTo(Admission::class, "admission_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function visit() {
        return $this->belongsTo(Visit::class, 'visit_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}