<?php

namespace Ignite\Inpatient\Entities;

use Ignite\Users\Entities\User;
use Ignite\Reception\Entities\Patients;

use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'ward_id',
        'bed_id',
        'cost',
        'reason',
        'external_doctor',
        'visit_id',
        'bedposition_id'
    ];

    protected $table = "admissions";

    public function patient(){
        return $this->belongsTo(Patients::class, "patient_id", "id");
    }

    public function doctor(){
        return $this->hasOne(User::class,'id', 'doctor_id');
    }

    public function ward(){
        return $this->hasOne(Ward::class, "id", "ward_id");
    }

    public function bed(){
        return $this->hasOne(Bed::class, "id", "bed_id");
    }

    public function visit(){
        return $this->belongsTo(Visit::class, "visit_id", "id");
    }
}
