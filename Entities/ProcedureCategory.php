<?php

namespace Ignite\Inpatient\Entities;

use Ignite\Evaluation\Entities\ProcedureCategoryTemplates;
use Ignite\Evaluation\Entities\Procedures;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Ignite\Inpatient\Entities\ProcedureCategory
 *
 * @property int $id
 * @property string $name
 * @property string $applies_to
 * @property string|null $deleted_at
 * @property-read mixed $applied_to
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Evaluation\Entities\Procedures[] $procedures
 * @property-read \Ignite\Evaluation\Entities\ProcedureCategoryTemplates $templates
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inpatient\Entities\ProcedureCategory onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\ProcedureCategory whereAppliesTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\ProcedureCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\ProcedureCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\ProcedureCategory whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inpatient\Entities\ProcedureCategory withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inpatient\Entities\ProcedureCategory withoutTrashed()
 * @mixin \Eloquent
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
