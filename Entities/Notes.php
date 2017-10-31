<?php

namespace Ignite\Inpatient\Entities;

use Ignite\Inpatient\Entities\Admission;
use Illuminate\Database\Eloquent\Model;

use Ignite\Users\Entities\User;

/**
 * Ignite\Inpatient\Entities\Notes
 *
 * @property int $id
 * @property int $admission_id
 * @property int $visit_id
 * @property string $notes
 * @property mixed|null $note_pic
 * @property int $user
 * @property int $type
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Inpatient\Entities\Admission $admission
 * @property-read \Ignite\Users\Entities\User $users
 * @property-read \Ignite\Inpatient\Entities\Visit $visit
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Notes whereAdmissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Notes whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Notes whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Notes whereNotePic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Notes whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Notes whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Notes whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Notes whereUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Notes whereVisitId($value)
 * @mixin \Eloquent
 */
class Notes extends Model
{
    public $table = 'inpatient_notes';
    protected $fillable = ['admission_id', 'visit_id', 'notes', 'type', 'user'];
    protected $guarded = [];

    public function admission(){
        return $this->belongsTo(Admission::class, "admission_id", "id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visit() {
        return $this->belongsTo(Visit::class, 'visit_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users() {
        return $this->belongsTo(User::class, 'user');
    }

}
