<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

class ChargeSheetType extends Model
{
    protected $table = "inpatient_charge_sheet_types";

    protected $fillable = [
        'name', 'description'
    ];
}
