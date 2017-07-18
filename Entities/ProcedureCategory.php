<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $id
 * @property array|\ArrayAccess|\Illuminate\Container\Container|mixed|void $applied_to
 * @property mixed $procedures
 * @property mixed $templates
 */
class ProcedureCategory extends Model
{
    use SoftDeletes;

    public $timestamps = false;
    public $table = 'evaluation_procedure_categories';
    protected $guarded = [];

    /**
     * @return mixed
     */
    public function getAppliedToAttribute() {
        return mconfig('evaluation.options.applies_to.' . $this->applies_to);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function procedures() {
        return $this->hasMany(Procedures::class, 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function templates() {
        return $this->hasOne(ProcedureCategoryTemplates::class, 'category');
    }

}
