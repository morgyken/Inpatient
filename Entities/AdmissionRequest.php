<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

use Ignite\Reception\Entities\Patients;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Ignite\Inpatient\Entities\AdmissionRequest
 *
 * @property int $id
 * @property int $patient_id
 * @property int $visit_id
 * @property int $admission_type_id
 * @property string $reason
 * @property float $authorized
 * @property int $authorized_by
 * @property int $cancelled
 * @property \Carbon\Carbon|null $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Inpatient\Entities\AdmissionType $admissionType
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Inpatient\Entities\InsuranceMaximumAmount[] $insuranceMaximumAmount
 * @property-read \Ignite\Reception\Entities\Patients $patient
 * @property-read \Ignite\Inpatient\Entities\Visit $visits
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inpatient\Entities\AdmissionRequest onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\AdmissionRequest whereAdmissionTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\AdmissionRequest whereAuthorized($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\AdmissionRequest whereAuthorizedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\AdmissionRequest whereCancelled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\AdmissionRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\AdmissionRequest whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\AdmissionRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\AdmissionRequest wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\AdmissionRequest whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\AdmissionRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\AdmissionRequest whereVisitId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inpatient\Entities\AdmissionRequest withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inpatient\Entities\AdmissionRequest withoutTrashed()
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
