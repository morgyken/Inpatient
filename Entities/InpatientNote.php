<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

class InpatientNote extends Model
{
    protected $fillable = [
        'visit_id', 'notes', 'title', 'type'
    ];

    protected $table = 'inpatient_notes';
}
