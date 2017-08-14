<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

class PatientAccount extends Model
{
    protected $fillable = [
        'patient_id','balance'
    ];

    protected $table = 'Patient_account';

    public function patient(){
    	return $this->belongsTo(Patients::class, 'patient');
    }
}
