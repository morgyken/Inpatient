<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;
use Ignite\Inpatient\Entities\Admission;
use Ignite\Inpatient\Entities\Visit;
use Ignite\Users\Entities\User;

/**
 * Ignite\Inpatient\Entities\NursingCarePlan
 *
 * @property int $id
 * @property int $admission_id
 * @property int $visit_id
 * @property int $user_id
 * @property string $diagnosis
 * @property string $expected_outcome
 * @property string $intervention
 * @property string $reasons
 * @property string $evaluation
 * @property string $date_recorded
 * @property string $time_recorded
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string $assessment
 * @property-read \Ignite\Inpatient\Entities\Admission $admission
 * @property-read \Ignite\Users\Entities\User $user
 * @property-read \Ignite\Inpatient\Entities\Visit $visit
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\NursingCarePlan whereAdmissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\NursingCarePlan whereAssessment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\NursingCarePlan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\NursingCarePlan whereDateRecorded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\NursingCarePlan whereDiagnosis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\NursingCarePlan whereEvaluation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\NursingCarePlan whereExpectedOutcome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\NursingCarePlan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\NursingCarePlan whereIntervention($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\NursingCarePlan whereReasons($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\NursingCarePlan whereTimeRecorded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\NursingCarePlan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\NursingCarePlan whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\NursingCarePlan whereVisitId($value)
 * @mixin \Eloquent
 */
class NursingCarePlan extends Model
{
    protected $fillable = ['admission_id', 'visit_id', 'user_id', 'assessment', 'diagnosis', 'expected_outcome', 'intervention', 'reasons', 'evaluation'];

    protected $table = "inpatient_nursing_care_plan";

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
