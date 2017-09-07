<?php

namespace Ignite\Inpatient\Entities;

use Ignite\Evaluation\Entities\Dispensing;
use Ignite\Inventory\Entities\InventoryProducts;
use Ignite\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inpatient\Entities\Prescription
 *
 * @property int $id
 * @property int $visit
 * @property string $drug
 * @property int $take
 * @property int $whereto
 * @property int $method
 * @property int $duration
 * @property int $status
 * @property bool $allow_substitution
 * @property int $time_measure
 * @property int $user
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $admission_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Evaluation\Entities\Dispensing[] $dispensing
 * @property-read \Ignite\Inventory\Entities\InventoryProducts $drugs
 * @property-read string $dose
 * @property-read string $sub
 * @property-read \Ignite\Users\Entities\User $users
 * @property-read \Ignite\Inpatient\Entities\Visit $visits
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Prescription whereAdmissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Prescription whereAllowSubstitution($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Prescription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Prescription whereDrug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Prescription whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Prescription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Prescription whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Prescription whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Prescription whereTake($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Prescription whereTimeMeasure($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Prescription whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Prescription whereUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Prescription whereVisit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Prescription whereWhereto($value)
 * @mixin \Eloquent
 */
class Prescription extends Model
{
    public $table = 'evaluation_prescriptions';
    protected $casts = ['allow_substitution' => 'boolean'];
    public $incrementing = false;
    protected $guarded = [];

    /**
     * @return string
     */
    public function getDoseAttribute()
    {
        return $this->take . ' ' . mconfig('evaluation.options.prescription_whereto.' . $this->whereto) . ' '
            . mconfig('evaluation.options.prescription_method.' . $this->method) . ' '
            . $this->duration . ' ' . mconfig('evaluation.options.prescription_duration.' . $this->time_measure);
    }

    /**
     * @return string
     */
    public function getSubAttribute()
    {
        return $this->allow_substitution ? 'Yes' : 'No';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visits()
    {
        return $this->belongsTo(Visit::class, 'visit');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function drugs()
    {
        return $this->belongsTo(InventoryProducts::class, 'drug');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'user');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dispensing()
    {
        return $this->hasMany(Dispensing::class, 'prescription');
    }
}
