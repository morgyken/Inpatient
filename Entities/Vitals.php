<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;
use Ignite\Users\Entities\User;
use Ignite\Inpatient\Entities\Admission;

class Vitals extends Model {

    public $table = 'inpatient_vitals';

    public function visits() {
        return $this->belongsTo(Visit::class, 'visit_id');
    }

    public function admissions() {
        return $this->belongsTo(Admission::class, 'admission_id');
    }

    public function user(){
    	return $this->hasOne(User::class, 'id', 'user_id');
    }

}
