<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;
use Ignite\Inpatient\Entities\Beds;
use Ignite\Inpatient\Entities\Admission;
use Ignite\Inpatient\Repositories\Traits\SlugableTrait;

class Wards extends Model
{
    use SlugableTrait;

    const CAT_MEN = 'Men';
    const CAT_WOMEN = 'Women';
    const CAT_CHILDREN  = 'Children';
    const CAT_MATERNITY = 'Maternity';
    const CAT_EMERGENCY= 'Emergency';
    const CAT_SURGERY = 'Surgery';

    protected $table = 'wards';
    protected $fillable = ['name', 'slug', 'is_available', 'category', 'capacity'];
    protected $slug_source = 'name';

    public function beds()
    {
        return $this->hasMany(Beds::class);
    }

    public function admissions()
    {
        $this->hasMany(Admission::class, 'ward_id');
    }
}
