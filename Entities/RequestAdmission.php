<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

use Ignite\Reception\Entities\Patients;
/**
 * Ignite\Inpatient\Entities\RequestAdmission
 *
 * @property int $id
 * @property int $patient_id
 * @property int|null $visit_id
 * @property string|null $reason
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Reception\Entities\Patients $patient
 * @property-read \Ignite\Inpatient\Entities\Visit|null $visits
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\RequestAdmission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\RequestAdmission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\RequestAdmission wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\RequestAdmission whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\RequestAdmission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\RequestAdmission whereVisitId($value)
 * @mixin \Eloquent
 */
class RequestAdmission extends Model
{
    protected $fillable = [
        'reason','patient_id','visit_id'
    ];
    protected $table = 'inpatient_request_admissions';

    public function patient(){
    	return $this->belongsTo(Patients::class, 'patient_id', 'id');
    }

    public function visits(){
    	return $this->belongsTo(Visit::class, 'visit_id', 'id');
    }
}
