<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

use Ignite\Evaluation\Entities\Visit;

use Ignite\Inpatient\Entities\DischargeType;

use Illuminate\Database\Eloquent\SoftDeletes;

class DischargeRequest extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'visit_id', 'discharge_type_id', 'notes', 'deleted_at'
    ];

    /*
    * Relationship between a discharge request and a visit
    */
    public function visit()
    {
        return $this->belongsTo(Visit::class, 'visit_id');
    }

    /*
    * Relationship between a discharge request and a discharge type
    */
    public function type()
    {
        return $this->belongsTo(DischargeType::class, 'discharge_type_id');
    }
}
