<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

class AdmissionCategory extends Model
{
    protected $fillable = ['name', 'slug', 'description' ];
    protected $table = 'admission_procedure_category';

    public function admission_procedure()
    {
        return $this->hasMany(AdmissionProcedures::class);
    }
}
