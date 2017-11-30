<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

class InpatientDoctorNotes extends Model
{
    protected $fillable = [
        'visit_id', 'notes'
    ];

    protected $table = 'inpatient_doctor_notes';
}
