<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $id
 */
class WardAssigned extends Model
{
    protected $fillable = [
        'visit_id',
        'ward_id',
        'admitted_at',
        'discharged_at',
        'price',
        'status'
    ];
    protected $table = 'ward_assigned';
}
