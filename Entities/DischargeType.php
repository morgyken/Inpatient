<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

class DischargeType extends Model
{
    protected $fillable = [
        'name', 'description'
    ];

    protected $table = "inpatient_discharge_types";
}
