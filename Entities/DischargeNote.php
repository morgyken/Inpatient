<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

use Ignite\Inpatient\Entities\Admission;
use Ignite\Inpatient\Entities\Visit;
use Ignite\Users\Entities\User;

/**
 * Ignite\Inpatient\Entities\DischargeNote
 *
 * @property int $id
 * @property int $admission_id
 * @property int|null $doctor_id
 * @property int|null $visit_id
 * @property string|null $case_note
 * @property string|null $principal_diagnosis
 * @property string|null $other_diagnosis
 * @property string|null $admission_complaints
 * @property string|null $investigations_courses
 * @property string|null $discharge_condition
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string $to_come_again
 * @property string|null $dateofdeath
 * @property string|null $timeofdeath
 * @property string $type
 * @property-read \Ignite\Inpatient\Entities\Admission $admission
 * @property-read \Ignite\Users\Entities\User|null $doctor
 * @property-read \Ignite\Inpatient\Entities\Visit|null $visit
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\DischargeNote whereAdmissionComplaints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\DischargeNote whereAdmissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\DischargeNote whereCaseNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\DischargeNote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\DischargeNote whereDateofdeath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\DischargeNote whereDischargeCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\DischargeNote whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\DischargeNote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\DischargeNote whereInvestigationsCourses($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\DischargeNote whereOtherDiagnosis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\DischargeNote wherePrincipalDiagnosis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\DischargeNote whereTimeofdeath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\DischargeNote whereToComeAgain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\DischargeNote whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\DischargeNote whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\DischargeNote whereVisitId($value)
 * @mixin \Eloquent
 */
class DischargeNote extends Model
{
   
    protected $table = 'inpatient_discharge_notes';

    public function admission(){
        return $this->belongsTo(Admission::class, "admission_id", "id");
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
    public function doctor() {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
