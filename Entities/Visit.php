<?php

namespace Ignite\Inpatient\Entities;

use Ignite\Evaluation\Entities\Dispensing;
use Ignite\Evaluation\Entities\DoctorNotes;
use Ignite\Evaluation\Entities\Drawings;
use Ignite\Evaluation\Entities\Investigations;
use Ignite\Evaluation\Entities\OpNotes;
use Ignite\Evaluation\Entities\PartnerInstitution;
use Ignite\Evaluation\Entities\Prescriptions;
use Ignite\Evaluation\Entities\Vitals;
use Ignite\Reception\Entities\Appointments;
use Ignite\Reception\Entities\PatientInsurance;
use Ignite\Reception\Entities\Patients;
use Ignite\Settings\Entities\Clinics;
use Ignite\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Ignite\Inpatient\Entities\Visit
 *
 * @property int $id
 * @property int $clinic
 * @property int $patient
 * @property int|null $purpose
 * @property int|null $external_doctor
 * @property string|null $inpatient
 * @property int $user
 * @property string $payment_mode
 * @property int|null $scheme
 * @property int|null $next_appointment
 * @property string|null $status
 * @property string|null $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $external_order
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Inpatient\Entities\Admission[] $admissions
 * @property-read \Ignite\Reception\Entities\Appointments $appointments
 * @property-read \Ignite\Settings\Entities\Clinics $clinics
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Inpatient\Entities\VisitDestinations[] $destinations
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Evaluation\Entities\Dispensing[] $dispensing
 * @property-read \Ignite\Users\Entities\User $doctors
 * @property-read \Ignite\Evaluation\Entities\Drawings $drawings
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Inventory\Entities\InventoryBatchProductSales[] $drug_purchases
 * @property-read \Ignite\Users\Entities\User|null $external_doctors
 * @property-read string $doctor
 * @property-read string $doctor_i_d
 * @property-read mixed|string $mode
 * @property-read mixed $signed_out
 * @property-read mixed $total_bill
 * @property-read int $unpaid_amount
 * @property-read mixed $visit_destination
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Evaluation\Entities\Investigations[] $investigations
 * @property-read \Ignite\Inpatient\Entities\VisitMeta $metas
 * @property-read \Ignite\Evaluation\Entities\DoctorNotes $notes
 * @property-read \Ignite\Evaluation\Entities\OpNotes $opnotes
 * @property-read \Ignite\Reception\Entities\PatientInsurance|null $patient_scheme
 * @property-read \Ignite\Reception\Entities\Patients $patients
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Evaluation\Entities\Prescriptions[] $prescriptions
 * @property-read \Ignite\Evaluation\Entities\PartnerInstitution $requesting_institutions
 * @property-read \Ignite\Evaluation\Entities\Vitals $vitals
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Inpatient\Entities\WardAssigned[] $wardsAssigned
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Visit checkedAt($destination)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inpatient\Entities\Visit onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Visit whereClinic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Visit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Visit whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Visit whereExternalDoctor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Visit whereExternalOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Visit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Visit whereInpatient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Visit whereNextAppointment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Visit wherePatient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Visit wherePaymentMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Visit wherePurpose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Visit whereScheme($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Visit whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Visit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\Visit whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inpatient\Entities\Visit withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inpatient\Entities\Visit withoutTrashed()
 * @mixin \Eloquent
 */
class Visit extends Model
{
    use SoftDeletes;

    public $table = 'evaluation_visits';
    protected $fillable = ['inpatient', 'clinic', 'patient', 'purpose', 'external_doctor', 'user',
        'payment_mode', 'scheme', 'next_appointment', 'status'];

    /**
     * @return int
     */
    public function getUnpaidAmountAttribute()
    {
        $amount = 0;
        $amount += $this->dispensing->where('payment_status', 0)->sum('amount');
        $amount += $this->investigations->where('is_paid', 0)->sum('price');
        return $amount;
    }

    public function getVisitDestinationAttribute()
    {
        return implode(' | ', $this->destinations->pluck('department')->toArray());
    }

    public function getSignedOutAttribute()
    {
        return empty($this->visit_destination);
    }

    /**
     * @param $query
     * @param $destination
     * @return mixed
     */
    public function scopeCheckedAt($query, $destination)
    {
        return $query->whereHas('destinations', function ($query) use ($destination) {
            $query->whereDepartment($destination);
            $query->whereCheckout(0);
        });
    }

    /**
     * @return mixed|string
     */
    public function getModeAttribute()
    {
        if ($this->payment_mode == 'insurance') {

            try {
                return ucfirst($this->payment_mode) . " | " .
                    $this->patient_scheme->schemes->companies->name . " | " .
                    $this->patient_scheme->schemes->name;
            } catch (\Exception $exc) {
                return ucfirst($this->payment_mode);
            }

        }
        return ucfirst($this->payment_mode);
    }

    /**
     * @return mixed
     */
    public function getTotalBillAttribute()
    {
        return $this->investigations->sum('price');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function clinics()
    {
        return $this->belongsTo(Clinics::class, 'clinic');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patients()
    {
        return $this->belongsTo(Patients::class, 'patient');
    }

    public function admissions()
    {
        return $this->hasMany(Admission::class, 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function vitals()
    {
        return $this->hasOne(Vitals::class, 'visit');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function notes()
    {
        return $this->hasOne(DoctorNotes::class, 'visit');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function drawings()
    {
        return $this->hasOne(Drawings::class, 'visit');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prescriptions()
    {
        return $this->hasMany(Prescriptions::class, 'visit');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function investigations()
    {
        return $this->hasMany(Investigations::class, 'visit');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dispensing()
    {
        return $this->hasMany(Dispensing::class, 'visit');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function opnotes()
    {
        return $this->hasOne(OpNotes::class, 'visit');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function appointments()
    {
        return $this->belongsTo(Appointments::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function doctors()
    {
        return $this->belongsTo(User::class, 'destination');
    }

    /**
     * @return string
     */
    public function getDoctorAttribute()
    {
        foreach ($this->destinations as $d) {
            if ($d->destination > 0) {
                return $d->medics->profile->name;
            } else {
                return '';
            }
        }
        //return $doc;
    }

    /**
     * @return string
     */
    public function getDoctorIDAttribute()
    {
        foreach ($this->destinations as $d) {
            if ($d->destination > 0) {
                return $d->medics->id;
            } else {
                return '';
            }
        }
        //return $doc;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient_scheme()
    {
        return $this->belongsTo(PatientInsurance::class, 'scheme');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requesting_institutions()
    {
        return $this->belongsTo(PartnerInstitution::class, 'requesting_institution');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function metas()
    {
        return $this->hasOne(VisitMeta::class, 'visit');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function destinations()
    {
        return $this->hasMany(VisitDestinations::class, 'visit');
    }

    public function drug_purchases()
    {
        return $this->hasMany(\Ignite\Inventory\Entities\InventoryBatchProductSales::class, 'id', 'visit');
    }

    public function external_doctors()
    {
        return $this->belongsTo(User::class, 'external_doctor');
    }

    public function wardsAssigned()
    {
        return $this->hasMany(WardAssigned::class, "visit_id");
    }


}
