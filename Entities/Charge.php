<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

use Ignite\Inpatient\Entities\Ward;

/**
 * Ignite\Inpatient\Entities\Charge
 *
 * @property int $id
 * @property string $name
 * @property float $cost
 * @property string $type
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Inpatient\Entities\Ward[] $wards
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Charge whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Charge whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Charge whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Charge whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Charge whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Charge whereUpdatedAt($value)
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
    public function wards()
    {
        return $this->belongsToMany(Ward::class, 'inpatient_ward_charges', 'charge_id', 'ward_id')
                    ->withTimestamps();
    }
}
