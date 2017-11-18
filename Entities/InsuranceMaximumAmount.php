<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

class InsuranceMaximumAmount extends Model
{
    protected $fillable = [
        'admission_request_id', 'scheme_id', 'maximum_amount', 'authorization_letter_url'
    ];

    protected $table = "inpatient_insurance_maximum_amounts";


}
