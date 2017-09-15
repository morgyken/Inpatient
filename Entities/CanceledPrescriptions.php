<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

use Ignite\Inpatient\Entities\Admission;
use Ignite\Inpatient\Entities\Visit;
use Ignite\Inventory\Entities\InventoryProducts;
use Ignite\Users\Entities\User;

/**
 * Ignite\Inpatient\Entities\CanceledPrescriptions
 *
 * @property int $id
 * @property int $admission_id
 * @property int $visit_id
 * @property string $drug
 * @property int $take
 * @property int $whereto
 * @property int $method
 * @property int $duration
 * @property bool $allow_substitution
 * @property int $time_measure
 * @property string $reason
 * @property int $user_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Inpatient\Entities\Admission $admission
 * @property-read \Ignite\Inventory\Entities\InventoryProducts $drugs
 * @property-read string $dose
 * @property-read string $sub
 * @property-read \Ignite\Users\Entities\User $user
 * @property-read \Ignite\Inpatient\Entities\Visit $visit
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\CanceledPrescriptions whereAdmissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\CanceledPrescriptions whereAllowSubstitution($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\CanceledPrescriptions whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\CanceledPrescriptions whereDrug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\CanceledPrescriptions whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\CanceledPrescriptions whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\CanceledPrescriptions whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\CanceledPrescriptions whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\CanceledPrescriptions whereTake($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\CanceledPrescriptions whereTimeMeasure($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\CanceledPrescriptions whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\CanceledPrescriptions whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\CanceledPrescriptions whereVisitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\CanceledPrescriptions whereWhereto($value)
 * @mixin \Eloquent
 */
class CanceledPrescriptions extends Model
{
    protected $fillable = [];
    protected $table = "inpatient_canceled_prescriptions";

    protected $casts = ['allow_substitution' => 'boolean'];

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
    public function admission()
    {
        return $this->belongsTo(Admission::class, 'admission_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function visit()
    {
        return $this->belongsTo(Visit::class, 'visit_id');
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
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
