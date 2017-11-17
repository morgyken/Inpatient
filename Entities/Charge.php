<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

use Ignite\Inpatient\Entities\Ward;

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
 * @property-read \Ignite\Inpatient\Entities\Ward|null $ward
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\NursingCharge whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\NursingCharge whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\NursingCharge whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\NursingCharge whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\NursingCharge whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\NursingCharge whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\NursingCharge whereWardId($value)
 * @mixin \Eloquent
 */
class Charge extends Model
{
    protected $fillable = [
        'name', 'cost', 'ward_id', 'type'
    ];

    protected $table = "inpatient_charges";

    /*
    * Realtionship between a charge and all the wards that belong to it
    */
    public function ward()
    {
        return $this->belongsToMany(Ward::class, 'inpatient_ward_charges', 'charge_id', 'ward_id')
                    ->withTimestamps();
    }
}
