<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;
use Ignite\Users\Entities\User;
use Ignite\Reception\Entities\Patients;

class Vitals extends Model {

    public $table = 'inpatient_vitals';

    public function visits() {
        return $this->belongsTo(Visit::class, 'visit_id');
    }

    public function admissions() {
        return $this->belongsTo(Patients::class, 'admission_id');
    }

    public function nurse(){
    	return $this->hasOne(User::class, 'id', 'user_id');
    }

}