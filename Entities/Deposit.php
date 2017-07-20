<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $fillable = ['cost','name'];
    protected $table = 'deposits';
}
