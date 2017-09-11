<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

use Ignite\Inpatient\Entities\Admission;
use Ignite\Inpatient\Entities\Visit;
use Ignite\Inventory\Entities\InventoryProducts;
use Ignite\Users\Entities\User;

class CanceledPrescriptions extends Model
{
    protected $fillable = [];
    protected $table = "inpatient_canceled_prescriptions";

    protected $casts = ['allow_substitution' => 'boolean'];

     /**
     * @return string
    */
    public function getDoseAttribute()
    {
        return $this->take . ' ' . mconfig('evaluation.options.prescription_whereto.' . $this->whereto) . ' '
            . mconfig('evaluation.options.prescription_method.' . $this->method) . ' '
            . $this->duration . ' ' . mconfig('evaluation.options.prescription_duration.' . $this->time_measure);
    }

    /**
     * @return string
    */
    public function getSubAttribute()
    {
        return $this->allow_substitution ? 'Yes' : 'No';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function admission()
    {
        return $this->belongsTo(Admission::class, 'admission_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function visit()
    {
        return $this->belongsTo(Visit::class, 'visit_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function drugs()
    {
        return $this->belongsTo(InventoryProducts::class, 'drug');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
