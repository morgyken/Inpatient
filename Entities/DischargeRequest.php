<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

use Ignite\Evaluation\Entities\Visit;

use Ignite\Inpatient\Entities\DischargeType;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Ignite\Inpatient\Entities\DischargeRequest
 *
 * @property int $id
 * @property int $visit_id
 * @property int $discharge_type_id
 * @property string $principal
 * @property string $other
 * @property string $complains
 * @property string $investigations
 * @property string $conditions
 * @property string $medication
 * @property string|null $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Inpatient\Entities\DischargeType $type
 * @property-read \Ignite\Evaluation\Entities\Visit $visit
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inpatient\Entities\DischargeRequest onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\DischargeRequest whereComplains($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\DischargeRequest whereConditions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\DischargeRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\DischargeRequest whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\DischargeRequest whereDischargeTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\DischargeRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\DischargeRequest whereInvestigations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\DischargeRequest whereMedication($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\DischargeRequest whereOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\DischargeRequest wherePrincipal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\DischargeRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\DischargeRequest whereVisitId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inpatient\Entities\DischargeRequest withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inpatient\Entities\DischargeRequest withoutTrashed()
 * @mixin \Eloquent
 */
class DischargeRequest extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'visit_id', 'discharge_type_id', 'principal', 'other', 'complains', 'investigations', 'conditions',	'medication', 'deleted_at'
    ];

    protected $table = 'inpatient_discharge_requests';

    /*
    * Relationship between a discharge request and a visit
    */
    public function visit()
    {
        return $this->belongsTo(Visit::class, 'visit_id');
    }

    /*
    * Relationship between a discharge request and a discharge type
    */
    public function type()
    {
        return $this->belongsTo(DischargeType::class, 'discharge_type_id');
    }
}
