<?php

namespace Ignite\Inpatient\Entities;

use Ignite\Evaluation\Entities\ProcedureCategories;
use Ignite\Evaluation\Entities\ProcedureInventoryItem;
use Ignite\Evaluation\Entities\ProcedureTemplates;
use Ignite\Evaluation\Entities\SubProcedures;
use Ignite\Settings\Entities\CompanyPrice;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inpatient\Entities\Procedure
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property int $category
 * @property string|null $gender
 * @property int|null $template
 * @property float $cash_charge
 * @property float|null $insurance_charge
 * @property int $charge_insurance
 * @property int $precharge
 * @property string|null $description
 * @property int $status
 * @property int $sensitivity
 * @property-read \Ignite\Evaluation\Entities\ProcedureCategories $categories
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Evaluation\Entities\SubProcedures[] $children
 * @property-read int $price
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Settings\Entities\CompanyPrice[] $inclusions
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Evaluation\Entities\ProcedureInventoryItem[] $items
 * @property-read \Ignite\Evaluation\Entities\ProcedureTemplates $templates
 * @property-read \Ignite\Evaluation\Entities\SubProcedures $this_test
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Procedure whereCashCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Procedure whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Procedure whereChargeInsurance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Procedure whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Procedure whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Procedure whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Procedure whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Procedure whereInsuranceCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Procedure whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Procedure wherePrecharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Procedure whereSensitivity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Procedure whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Procedure whereTemplate($value)
 * @mixin \Eloquent
 */
class Procedure extends Model
{
    public $table = 'evaluation_procedures';
    protected $guarded = [];
    protected $appends = ['price'];
    protected $hidden = ['cah_charge'];
    public $timestamps = false;

    /**
     * @return int
     */
    public function getPriceAttribute()
    {
        return (int)ceil($this->cash_charge);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categories()
    {
        return $this->belongsTo(ProcedureCategories::class, 'category');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(ProcedureInventoryItem::class, 'procedure');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function this_test()
    {
        return $this->belongsTo(SubProcedures::class, 'id', 'procedure');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(SubProcedures::class, 'parent');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function inclusions()
    {
        return $this->hasMany(CompanyPrice::class, 'procedure');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function templates()
    {
        return $this->hasOne(ProcedureTemplates::class, 'procedure');
    }
}
