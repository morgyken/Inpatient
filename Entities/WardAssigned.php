<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inpatient\Entities\WardAssigned
 *
 * @property int $id
 * @property int $admission_id
 * @property int|null $visit_id
 * @property int $ward_id
 * @property string|null $admitted_at
 * @property string|null $discharged_at
 * @property float $price
 * @property string $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\WardAssigned whereAdmissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\WardAssigned whereAdmittedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\WardAssigned whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\WardAssigned whereDischargedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\WardAssigned whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\WardAssigned wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\WardAssigned whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\WardAssigned whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\WardAssigned whereVisitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\WardAssigned whereWardId($value)
 * @mixin \Eloquent
 */
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
