<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

class WardAssigned extends Model
{
    protected $fillable = [
        // 'patient_id',
        'visit_id',
        'ward_id',
        'admitted_at',
        'discharged_at',
        'price',
        'status'
    ];
    
    protected $table = 'ward_assigned';

    // public function patient(){
    //     $this->belongsTo(Patients::class, "patient_id", "id");
    // }

    public function ward(){
    	$this->belongsTo(Ward::class, "ward_id", "id");
    }

    public function visit(){
    	$this->belongsTo(Visit::class, "visit_id", "id");
    }
}
