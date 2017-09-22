<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

use Ignite\Inpatient\Entities\Ward;
use Ignite\Inpatient\Entities\BedType;
/**
 * Ignite\Inpatient\Entities\Bed
 *
 * @property int $id
 * @property string $number
 * @property string $type
 * @property string $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Inpatient\Entities\Ward $ward
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Bed whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Bed whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Bed whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Bed whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Bed whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Bed whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Bed extends Model
{
    protected $fillable = [
        'id',
        'number',
        'type',
        'status',
        'ward_id'
    ];

    protected $table = 'beds';

    public function ward(){
    	return $this->belongsTo(Ward::class, 'ward_id', 'id');
    }

     public function bedType(){
        return $this->belongsTo(BedType::class, 'type', 'id');
    }

}
