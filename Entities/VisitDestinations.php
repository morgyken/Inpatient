<?php

namespace Ignite\Inpatient\Entities;

use Ignite\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $visits
 * @property mixed $medics
 * @property \Carbon\Carbon $created_at
 * @property int $id
 * @property \Carbon\Carbon $updated_at
 */
class VisitDestinations extends Model
{
    public $table = 'evaluation_visit_destinations';
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visits() {
        return $this->hasMany(Visit::class, 'id', 'visit');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function medics() {
        return $this->belongsTo(User::class, 'destination');
    }
}
