<?php

namespace Ignite\Inpatient\Entities;

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
}
