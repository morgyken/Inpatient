<?php

namespace Ignite\Inpatient\Entities;

use Ignite\Reception\Entities\Patients;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inpatient\Entities\Ward
 *
 * @property int $id
 * @property string $number
 * @property string $name
 * @property string $gender
 * @property string $age_group
 * @property float $insurance_cost
 * @property float $cash_cost
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Inpatient\Entities\WardAssigned[] $assigned
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Inpatient\Entities\Bed[] $beds
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Inpatient\Entities\Charge[] $charges
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Reception\Entities\Patients[] $patients
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Ward whereAgeGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Ward whereCashCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Ward whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Ward whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Ward whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Ward whereInsuranceCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Ward whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Ward whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Ward whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Ward extends Model
{
    protected $fillable = [
        'name', 'number', 'category', 'insurance_cost', 'cash_cost', 'age_group', 'gender'
    ];

    protected $table = "inpatient_wards";

    /*
    * Relationship between the ward and patients in it
    */
    public function patients()
    {
        return $this->hasMany(Patients::class, 'patients'); 
    }


    public function assigned()
    {
        return $this->hasMany(WardAssigned::class);
    }

    /*
    * Relationship between the ward and beds in it
    */
    public function beds()
    {
        return $this->hasMany(Bed::class, 'ward_id', 'id');
    }

    /*
    * Relationship between the ward and charges that apply to it
    */
    public function charges()
    {
        return $this->belongsToMany(Charge::class, 'inpatient_ward_charges', 'ward_id', 'charge_id')
                    ->withTimestamps();
    }
}
