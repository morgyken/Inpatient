<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;
use Ignite\Inpatient\Entities\Ward;
use Ignite\Inpatient\Entities\Charge;
use Ignite\Evaluation\Entities\Dispensing;
use Ignite\Inpatient\Entities\InpatientConsumable;
use Ignite\Evaluation\Entities\Investigations;

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
 * @property-read \Ignite\Inpatient\Entities\Charge|null $charge
 * @property-read \Ignite\Inpatient\Entities\InpatientConsumable|null $consumable
 * @property-read \Ignite\Evaluation\Entities\Dispensing|null $dispense
 * @property-read \Ignite\Evaluation\Entities\Investigations|null $investigation
 * @property-read \Ignite\Inpatient\Entities\Ward|null $ward
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
        'visit_id', 'dispensing_id', 'consumable_id', 'charge_id', 'ward', 'price',  'ward_id'
    ];

    protected $table = "inpatient_charge_sheet";

    /*
    * Relationship between a charge and a ward
    */
    public function ward()
    {   
        return $this->belongsTo(Ward::class, 'ward_id');
    }

    /*
    * Relationship between a charge and an inventory consumable item
    */
    public function consumable()
    {   
        return $this->belongsTo(InpatientConsumable::class, 'consumable_id');
    }

    /*
    * Relationship between charge and recurring and one off charges
    */
    public function charge()
    {
        return $this->belongsTo(Charge::class, 'charge_id');
    }

    /*
    * Relationship between the charge and the dispensed drug
    */
    public function dispense()
    {
        return $this->belongsTo(Dispensing::class, 'dispensing_id');
    }

    /*
    * Relationship between an investigation and the charge sheet
    */
    public function investigation()
    {
        return $this->belongsTo(Investigations::class, 'investigation_id');
    }
}
