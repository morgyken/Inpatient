<?php

namespace Ignite\Inpatient\Entities;

use Ignite\Inventory\Entities\InventoryProducts;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inpatient\Entities\InpatientConsumable
 *
 * @property int $id
 * @property int $visit
 * @property string $type
 * @property int $product_id
 * @property int $quantity
 * @property float $discount
 * @property float $amount
 * @property float $price
 * @property int|null $user
 * @property string|null $instructions
 * @property int $ordered
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Inventory\Entities\InventoryProducts $product
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\InpatientConsumable whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\InpatientConsumable whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\InpatientConsumable whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\InpatientConsumable whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\InpatientConsumable whereInstructions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\InpatientConsumable whereOrdered($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\InpatientConsumable wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\InpatientConsumable whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\InpatientConsumable whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\InpatientConsumable whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\InpatientConsumable whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\InpatientConsumable whereUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\InpatientConsumable whereVisit($value)
 * @mixin \Eloquent
 */
class InpatientConsumable extends Model
{
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(InventoryProducts::class, 'product_id');
    }
}
