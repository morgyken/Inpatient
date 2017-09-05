<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inpatient\Entities\DischargeNote
 *
 * @property int $id
 * @property string|null $summary_note
 * @property string|null $case_note
 * @property int|null $doctor_id
 * @property int|null $visit_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\DischargeNote whereCaseNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\DischargeNote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\DischargeNote whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\DischargeNote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\DischargeNote whereSummaryNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\DischargeNote whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\DischargeNote whereVisitId($value)
 * @mixin \Eloquent
 */
class DischargeNote extends Model
{
    protected $fillable = [
        'case_note','summary_note','visit_id','patient_id'
    ];
    protected $table = 'dischargeNotes';
}
