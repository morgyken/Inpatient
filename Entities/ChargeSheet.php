<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

use Ignite\Inpatient\Entities\Ward;

/**
 * Ignite\Inpatient\Entities\ChargeSheet
 *
 * @property int $id
 * @property int $visit_id
 * @property int|null $dispensing_id rel:inventory_evaluation_dispensing
 * @property int|null $consumable_id rel:inpatient_consumables
 * @property int|null $investigation_id rel:evaluation_investigations
 * @property int|null $charge_id rel:inpatient_charges
 * @property int|null $ward_id rel:inpatient_wards
 * @property int $paid
 * @property float $price
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Inpatient\Entities\Ward[] $wards
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\ChargeSheet whereChargeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\ChargeSheet whereConsumableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\ChargeSheet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\ChargeSheet whereDispensingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\ChargeSheet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\ChargeSheet whereInvestigationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\ChargeSheet wherePaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\ChargeSheet wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\ChargeSheet whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\ChargeSheet whereVisitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\ChargeSheet whereWardId($value)
 * @mixin \Eloquent
 */
class ChargeSheet extends Model
{
    protected $fillable = [
        'visit_id', 'prescription_id', 'consumable_id', 'charge_id', 'ward', 'price',  'ward_id'
    ];

    protected $table = "inpatient_charge_sheet";

    /*
    * Relationship between a wards and a charge
    */
    public function wards()
    {   
        return $this->hasMany(Ward::class, 'id', 'ward_id');
    }
}
