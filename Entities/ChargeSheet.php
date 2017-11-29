<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

use Ignite\Inpatient\Entities\Ward;

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
