<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

class Beds extends Model
{
    protected $fillable = [ 'name', 'ward_id', 'status','bed_id'];

    protected $table = 'beds';
    protected $dates = ['created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ward()
    {
        return $this->belongsTo(Wards::class, 'ward_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function admission()
    {
        return $this->hasOne(Admission::class);
    }

}
