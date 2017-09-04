<?php

namespace Ignite\Inpatient\Entities;

use Ignite\Inpatient\Entities\Admission;
use Ignite\Users\Entities\User;

use Illuminate\Database\Eloquent\Model;

class HeadInjury extends Model
{

    protected $table = "inpatient_headinjury_and_craniotomy";

    public $casts = [
        'conscious_status' => 'array',
        'pupil_status' => 'array'
    ];

    public function admission(){
        return $this->belongsTo(Admission::class, "admission_id", "id");
    }

    public function user(){
        return $this->hasOne(User::class,'id', 'user_id', 'id');
    }

}
