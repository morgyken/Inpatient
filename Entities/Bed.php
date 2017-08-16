<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string number
 * @property \Carbon\Carbon $created_at
 * @property int $id
 * @property \Carbon\Carbon $updated_at
 */
class Bed extends Model
{
    protected $fillable = [
        'id',
        'number',
        'type',
        'status',
        'ward_id'
    ];

    protected $table = 'beds';

    public function ward(){
    	return $this->belongsTo(Ward::class, 'ward_id', 'id');
    }

}
