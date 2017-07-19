<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @property \Carbon\Carbon $created_at
 * @property int $id
 * @property \Carbon\Carbon $updated_at
 * @property mixed allow_substitution
 * @property mixed take
 * @property mixed duration
 * @property mixed $time_measure
 * @property string $dose
 * @property mixed whereto
 * @property mixed $method
 * @property string $sub
 * @property mixed $visits
 * @property mixed $drugs
 * @property mixed $dispensing
 */
class Prescription extends Model
{
    public $table = 'evaluation_prescriptions';
    protected $casts = ['allow_substitution' => 'boolean'];
    public $incrementing = false;
    protected $guarded = [];

    /**
     * @return string
     */
    public function getDoseAttribute() {
        return $this->take . ' ' . mconfig('evaluation.options.prescription_whereto.' . $this->whereto) . ' '
            . mconfig('evaluation.options.prescription_method.' . $this->method) . ' '
            . $this->duration . ' ' . mconfig('evaluation.options.prescription_duration.' . $this->time_measure);
    }

    /**
     * @return string
     */
    public function getSubAttribute() {
        return $this->allow_substitution ? 'Yes' : 'No';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visits() {
        return $this->belongsTo(Visit::class, 'visit');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function drugs() {
        return $this->belongsTo(InventoryProducts::class, 'drug');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users() {
        return $this->belongsTo(User::class, 'user');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dispensing() {
        return $this->hasMany(Dispensing::class, 'prescription');
    }
}
