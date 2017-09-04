<?php

namespace Ignite\Inpatient\Entities;

use Ignite\Inpatient\Entities\Admission;
use Ignite\Inpatient\Entities\Prescription;
use Ignite\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;

class Administration extends Model
{
    public $table = 'inpatient_administration_logs';
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admission() {
        return $this->belongsTo(Admission::class, 'admission_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function prescription() {
        return $this->belongsTo(Prescription::class, 'prescription_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users() {
        return $this->belongsTo(User::class, 'user');
    }

}
