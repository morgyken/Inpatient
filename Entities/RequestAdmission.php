<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

use Ignite\Reception\Entities\Patients;
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

    public function patient(){
    	return $this->belongsTo(Patients::class, 'patient_id', 'id');
    }

    public function visits(){
    	return $this->belongsTo(Visit::class, 'visit_id', 'id');
    }
}
