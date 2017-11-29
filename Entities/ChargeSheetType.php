<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inpatient\Entities\ChargeSheetType
 *
 * @mixin \Eloquent
 */
class ChargeSheetType extends Model
{
    protected $table = "inpatient_charge_sheet_types";

    protected $fillable = [
        'name', 'description'
    ];
}
