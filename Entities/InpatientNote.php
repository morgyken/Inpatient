<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inpatient\Entities\InpatientNote
 *
 * @property int $id
 * @property int $visit_id
 * @property string $title
 * @property string $type
 * @property string $notes
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\InpatientNote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\InpatientNote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\InpatientNote whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\InpatientNote whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\InpatientNote whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\InpatientNote whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\InpatientNote whereVisitId($value)
 * @mixin \Eloquent
 */
class InpatientNote extends Model
{
    protected $fillable = [
        'visit_id', 'notes', 'title', 'type'
    ];

    protected $table = 'inpatient_notes';
}
