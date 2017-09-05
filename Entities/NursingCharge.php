<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inpatient\Entities\NursingCharge
 *
 * @property int $id
 * @property string $name
 * @property float $cost
 * @property int|null $ward_id
 * @property string $type
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\NursingCharge whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\NursingCharge whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\NursingCharge whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\NursingCharge whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\NursingCharge whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\NursingCharge whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\NursingCharge whereWardId($value)
 * @mixin \Eloquent
 */
class NursingCharge extends Model
{
    protected $fillable = [];
}
