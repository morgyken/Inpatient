<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

class AdmissionType extends Model
{
    protected $fillable = [
    	'name', 'description'
    ];
}
