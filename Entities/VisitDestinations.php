<?php

namespace Ignite\Inpatient\Entities;

use Ignite\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inpatient\Entities\VisitDestinations
 *
 * @property int $id
 * @property int $visit
 * @property int $user
 * @property int|null $destination
 * @property string $department
 * @property int $checkout
 * @property string|null $begin_at
 * @property string|null $finish_at
 * @property string|null $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Users\Entities\User|null $medics
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Inpatient\Entities\Visit[] $visits
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\VisitDestinations whereBeginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\VisitDestinations whereCheckout($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\VisitDestinations whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\VisitDestinations whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\VisitDestinations whereDepartment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\VisitDestinations whereDestination($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\VisitDestinations whereFinishAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\VisitDestinations whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\VisitDestinations whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\VisitDestinations whereUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\VisitDestinations whereVisit($value)
 * @mixin \Eloquent
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
