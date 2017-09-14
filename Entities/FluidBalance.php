<?php

namespace Ignite\Inpatient\Entities;

use Ignite\Inpatient\Entities\Admission;
use Ignite\Users\Entities\User;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inpatient\Entities\FluidBalance
 *
 * @property int $id
 * @property int $admission_id
 * @property int $visit_id
 * @property int $user_id
 * @property string|null $bp_systolic
 * @property string|null $intravenous_infusion
 * @property string|null $other_instructions
 * @property array $intake_intraveneous
 * @property array $intake_alimentary
 * @property array $output
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Inpatient\Entities\Admission $admission
 * @property-read \Ignite\Users\Entities\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\FluidBalance whereAdmissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\FluidBalance whereBpSystolic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\FluidBalance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\FluidBalance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\FluidBalance whereIntakeAlimentary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\FluidBalance whereIntakeIntraveneous($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\FluidBalance whereIntravenousInfusion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\FluidBalance whereOtherInstructions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\FluidBalance whereOutput($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\FluidBalance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\FluidBalance whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\FluidBalance whereVisitId($value)
 * @mixin \Eloquent
 */
class FluidBalance extends Model
{

    protected $table = "inpatient_fluidbalance";

    public $casts = [
        'intake_intraveneous' => 'array',
        'intake_alimentary' => 'array',
        'output' => 'array'
    ];

    public function admission(){
        return $this->belongsTo(Admission::class, "admission_id", "id");
    }

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
