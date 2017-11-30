<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;
use Ignite\Settings\Entities\Schemes;

class Rebate extends Model
{
    protected $fillable = [
        'scheme_id', 'amount', 'description'
    ];

    protected $table = "inpatient_rebates";

    /*
    * Relationship between the NHIF scheme and the rebate
    */
    public function scheme()
    {
        return $this->belongsTo(Schemes::class, 'scheme_id');
    }
}
