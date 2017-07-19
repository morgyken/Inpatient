<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @property \Carbon\Carbon $created_at
 * @property int $id
 * @property \Carbon\Carbon $updated_at
 */
class RequestAdmission extends Model
{
    protected $fillable = [
        'reason','patient_id','visit_id'
    ];
    protected $table = 'request_admissions';
}
