<?php

namespace Ignite\Inpatient\Entities;

use Ignite\Evaluation\Entities\Prescriptions;
use Ignite\Inpatient\Entities\Admission;
use Ignite\Inpatient\Entities\Prescription;
use Ignite\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inpatient\Entities\Administration
 *
 * @property int $id
 * @property int $admission_id
 * @property int $visit_id
 * @property int $prescription_id
 * @property string $time
 * @property int $user
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Inpatient\Entities\Admission $admission
 * @property-read \Ignite\Evaluation\Entities\Prescriptions $prescription
 * @property-read \Ignite\Users\Entities\User $users
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Administration whereAdmissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Administration whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Administration whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Administration wherePrescriptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Administration whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Administration whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Administration whereUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Administration whereVisitId($value)
 * @mixin \Eloquent
 */
class Administration extends Model
{
    public $table = 'inpatient_administration_logs';
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admission()
    {
        return $this->belongsTo(Admission::class, 'admission_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function prescription()
    {
        return $this->belongsTo(Prescriptions::class, 'prescription_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'user');
    }

}
