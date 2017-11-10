<?php

namespace Ignite\Inpatient\Entities;

use Ignite\Reception\Entities\Patients;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inpatient\Entities\Ward
 *
 * @property int $id
 * @property string $name
 * @property string $number
 * @property string $category
 * @property string $cost
 * @property string $age_group
 * @property string $gender
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Inpatient\Entities\WardAssigned[] $assigned
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Inpatient\Entities\BedPosition[] $bedpositions
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Reception\Entities\Patients[] $patients
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Ward whereAgeGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Ward whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Ward whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Ward whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Ward whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Ward whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Ward whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Ward whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Ward whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Ward extends Model
{
    protected $fillable = [
        'name',
        'number',
        'category',
        'cost',
        'age_group',
        'gender'
    ];

    public function patients(){
    	return $this->hasMany(Patients::class, 'patients');
    }

    public function assigned(){
        return $this->hasMany(WardAssigned::class);
    }

    public function bedpositions()
    {
        return $this->hasMany(BedPosition::class,'ward_id', 'id');
    }

    public function beds()
    {
        return $this->hasMany(Bed::class, 'ward_id', 'id');
    }


}
