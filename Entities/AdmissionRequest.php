<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

use Ignite\Reception\Entities\Patients;

use Illuminate\Database\Eloquent\SoftDeletes;

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
class AdmissionRequest extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'patient_id','visit_id', 'admission_type_id', 'reason', 'authorized', 'authorized_by', 'canceled', 'deleted_at'
    ];

    protected $table = 'inpatient_admission_requests';

    protected $with = ['patient.account', 'admissionType', 'insuranceMaximumAmount'];

    protected $dates = ['deleted_at'];

    /*
    * Relationship between the patient and the admission request
    */
    public function patient()
    {
    	return $this->belongsTo(Patients::class, 'patient_id', 'id');
    }

    /*
    * Relationship between the visit and the admission request
    */
    public function visits()
    {
    	return $this->belongsTo(Visit::class, 'visit_id', 'id');
    }

    /*
    * Relationship between the request and the admission types
    */
    public function admissionType()
    {
        return $this->belongsTo(AdmissionType::class);
    }

    /*
    * Relationship between a visit and insurance maximum amounts
    */
    public function insuranceMaximumAmount()
    {
        return $this->hasMany(InsuranceMaximumAmount::class, 'admission_request_id');
    }
}
