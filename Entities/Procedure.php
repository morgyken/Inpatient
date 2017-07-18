<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $price
 * @property mixed $categories
 * @property mixed $items
 * @property int $id
 * @property mixed $this_test
 * @property mixed $children
 * @property mixed $inclusions
 * @property mixed $templates
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
    public function getPriceAttribute() {
        return (int) ceil($this->cash_charge);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categories() {
        return $this->belongsTo(ProcedureCategories::class, 'category');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items() {
        return $this->hasMany(ProcedureInventoryItem::class, 'procedure');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function this_test() {
        return $this->belongsTo(SubProcedures::class, 'id', 'procedure');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children() {
        return $this->hasMany(SubProcedures::class, 'parent');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function inclusions() {
        return $this->hasMany(\Ignite\Settings\Entities\CompanyPrice::class, 'procedure');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function templates() {
        return $this->hasOne(ProcedureTemplates::class, 'procedure');
    }
}
