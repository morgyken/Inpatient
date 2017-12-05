<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inpatient\Entities\Bed
 *
 * @property int $id
 * @property string $number
 * @property int $ward_id
 * @property int $bed_type_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Inpatient\Entities\Admission $admission
 * @property-read \Ignite\Inpatient\Entities\BedType $type
 * @property-read \Ignite\Inpatient\Entities\Ward $ward
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Bed whereBedTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Bed whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Bed whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Bed whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Bed whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Bed whereWardId($value)
 * @mixin \Eloquent
 */
class Bed extends Model
{
    protected $fillable = [
        'number', 'bed_type_id', 'ward_id'
    ];

    protected $table = 'inpatient_beds';

    protected $with = ['type', 'admission'];

    /*
    * Relationship between a bed and a ward
    */
    public function ward()
    {
    	return $this->belongsTo(Ward::class, 'ward_id', 'id');
    }

    /*
    * Relationship between a bed and a bedtype
    */
    public function type()
    {
        return $this->belongsTo(BedType::class, 'bed_type_id', 'id');   
    }

    /*
    * Relationship between a bed and an admission - hence patient
    */
    public function admission()
    {
        return $this->belongsTo(Admission::class, 'bed_id');
    }

}
