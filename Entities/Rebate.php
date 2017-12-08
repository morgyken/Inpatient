<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;
use Ignite\Settings\Entities\Schemes;

/**
 * Ignite\Inpatient\Entities\Rebate
 *
 * @property int $id
 * @property int $scheme_id
 * @property float $amount
 * @property string $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Settings\Entities\Schemes $scheme
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Rebate whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Rebate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Rebate whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Rebate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Rebate whereSchemeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Rebate whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Rebate extends Model
{
    protected $fillable = [
        'scheme_id', 'amount', 'description'
    ];

    protected $table = "inpatient_rebates";

    /*
    * Relationship between the NHIF scheme and the rebate
    */
    public function scheme()
    {
        return $this->belongsTo(Schemes::class, 'scheme_id');
    }
}
