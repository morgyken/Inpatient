<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @property \Carbon\Carbon $created_at
 * @property int $id
 * @property \Carbon\Carbon $updated_at
 * @property mixed $ward
 */
class BedPosition extends Model
{
    protected $table = 'bed_position';
    protected $fillable = ['name','ward_id','status'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_id');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsTaken($query)
    {
        if($query->where('status', 1) == true){
            return true;
        }

        return false;
    }


}
