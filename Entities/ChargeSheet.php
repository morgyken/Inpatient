<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

class ChargeSheet extends Model
{
    protected $fillable = [
        'visit_id', 'charge_sheet_type_id', 'units', 'unit_price', 'total', 'notes'
    ];

    protected $table = "inpatient_charge_sheet";
}
