<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

use Ignite\Inpatient\Entities\Visit;
use Ignite\Inpatient\DischargeNote;
use Ignite\Users\Entities\User;

/**
 * Ignite\Inpatient\Entities\Discharge
 *
 * @property int $id
 * @property int $admission_id
 * @property int|null $visit_id
 * @property int|null $doctor_id
 * @property string $type
 * @property string $DischargeNote
 * @property string|null $dateofdeath
 * @property string|null $timeofdeath
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Discharge whereAdmissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Discharge whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Discharge whereDateofdeath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Discharge whereDischargeNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Discharge whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Discharge whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Discharge whereTimeofdeath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Discharge whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Discharge whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Discharge whereVisitId($value)
 * @mixin \Eloquent
 */
class Discharge extends Model
{
    protected $fillable = [
        'visit_id',
        'doctor_id',
        'discharge_notes_id'
    ];

    protected $table = 'discharges';

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function notes() {
        return $this->belongsTo(DischargeNote::class, 'discharge_notes_id');
    }
}
