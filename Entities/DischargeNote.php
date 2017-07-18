<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @property \Carbon\Carbon $created_at
 * @property int $id
 * @property \Carbon\Carbon $updated_at
 */
class DischargeNote extends Model
{
    protected $fillable = [
        'case_note','summary_note','visit_id','patient_id'
    ];
    protected $table = 'dischargeNotes';
}
