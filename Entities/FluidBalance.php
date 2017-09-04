<?php

namespace Ignite\Inpatient\Entities;

use Ignite\Inpatient\Entities\Admission;
use Ignite\Users\Entities\User;

use Illuminate\Database\Eloquent\Model;

class FluidBalance extends Model
{

    protected $table = "inpatient_fluidbalance";

    public $casts = [
        'intake_intraveneous' => 'array',
        'intake_alimentary' => 'array',
        'output' => 'array'
    ];

    public function admission(){
        return $this->belongsTo(Admission::class, "admission_id", "id");
    }

    public function user(){
        return $this->hasOne(User::class,'id', 'user_id', 'id');
    }

}
