<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;
use Ignite\Inpatient\Entities\Ward;
use Ignite\Inpatient\Entities\Charge;
use Ignite\Evaluation\Entities\Dispensing;
use Ignite\Inpatient\Entities\InpatientConsumable;

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
}
