<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

class AdmissionType extends Model
{
    protected $fillable = [
    	'name', 'description', 'deposit'
    ];

    /*
    * Accessor for the name column - Sets the name to title case
    */
    public function getNameAttribute($value)
    {
        return ucwords($value);
    }
}
