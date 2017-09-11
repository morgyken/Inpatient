<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;
use Ignite\Inpatient\Entities\Admission;
use Ignite\Inpatient\Entities\Visit;
use Ignite\Users\Entities\User;

/**
 * Ignite\Inpatient\Entities\NurseCarePlan
 *
 * @mixin \Eloquent
 */
class NursingCarePlan extends Model
{
    protected $fillable = ['admission_id', 'visit_id', 'diagnosis', 'expected_outcome', 'intervention', 'reasons', 'evaluation'];

    protected $table = "inpatient_nursing_care_plan";

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function admission(){
        return $this->belongsTo(Admission::class, "admission_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function visit() {
        return $this->belongsTo(Visit::class, 'visit_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
