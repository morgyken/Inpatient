<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $admission_procedure
 */
class AdmissionCategory extends Model
{
    protected $fillable = ['name', 'slug', 'description' ];
    protected $table = 'admission_procedure_category';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     */
    public function admission_procedure()
    {
        return $this->hasMany(AdmissionProcedures::class);
    }
}
