<?php

namespace Ignite\Inpatient\Entities;

use Ignite\Reception\Entities\Patients;
use Illuminate\Database\Eloquent\Model;

/**
 * @property \Carbon\Carbon $created_at
 * @property int $id
 * @property \Carbon\Carbon $updated_at
 */
class Ward extends Model
{
    protected $fillable = [
        'name',
        'number',
        'category',
        'cost',
        'age_group',
        'gender'
    ];

    public function patients(){
    	return $this->hasMany(Patients::class, 'patients');
    }

    public function assigned(){
        return $this->hasMany(WardAssigned::class);
    }
}
