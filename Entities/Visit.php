<?php

namespace Ignite\Inpatient\Entities;

use Ignite\Evaluation\Entities\Dispensing;
use Ignite\Evaluation\Entities\DoctorNotes;
use Ignite\Evaluation\Entities\Drawings;
use Ignite\Evaluation\Entities\Investigations;
use Ignite\Evaluation\Entities\OpNotes;
use Ignite\Evaluation\Entities\Prescriptions;
use Ignite\Evaluation\Entities\Vitals;
use Ignite\Reception\Entities\Appointments;
use Ignite\Reception\Entities\Patients;
use Ignite\Settings\Entities\Clinics;
use Ignite\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Visit extends Model
{
    use SoftDeletes;

    public $table = 'evaluation_visits';
    protected $fillable = ['inpatient','clinic','patient','purpose','external_doctor','user',
        'payment_mode','scheme','next_appointment','status'];

    /**
     * @return int
     */
    public function getUnpaidAmountAttribute() {
        $amount = 0;
        $amount+= $this->dispensing->where('payment_status', 0)->sum('amount');
        $amount+= $this->investigations->where('is_paid', 0)->sum('price');
        return $amount;
    }

    public function getVisitDestinationAttribute() {
        return implode(' | ', $this->destinations->pluck('department')->toArray());
    }

    public function getSignedOutAttribute() {
        return empty($this->visit_destination);
    }

    /**
     * @param $query
     * @param $destination
     * @return mixed
     */
    public function scopeCheckedAt($query, $destination) {
        return $query->whereHas('destinations', function($query) use ($destination) {
            $query->whereDepartment($destination);
            $query->whereCheckout(0);
        });
    }

    /**
     * @return mixed|string
     */
    public function getModeAttribute() {
        if ($this->payment_mode == 'insurance') {

            try{
                return ucfirst($this->payment_mode) . " | " .
                    $this->patient_scheme->schemes->companies->name . " | " .
                    $this->patient_scheme->schemes->name;
            }
            catch(\Exception $exc){
                return ucfirst($this->payment_mode);
            }

        }
        return ucfirst($this->payment_mode);
    }

    /**
     * @return mixed
     */
    public function getTotalBillAttribute() {
        return $this->investigations->sum('price');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function clinics() {
        return $this->belongsTo(Clinics::class, 'clinic');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patients() {
        return $this->belongsTo(Patients::class, 'patient');
    }

    public function admissions(){
        return $this->hasMany(Admission::class, 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function vitals() {
        return $this->hasOne(Vitals::class, 'visit');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function notes() {
        return $this->hasOne(DoctorNotes::class, 'visit');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function drawings() {
        return $this->hasOne(Drawings::class, 'visit');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prescriptions() {
        return $this->hasMany(Prescriptions::class, 'visit');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function investigations() {
        return $this->hasMany(Investigations::class, 'visit');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dispensing() {
        return $this->hasMany(Dispensing::class, 'visit');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function opnotes() {
        return $this->hasOne(OpNotes::class, 'visit');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function appointments() {
        return $this->belongsTo(Appointments::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function doctors() {
        return $this->belongsTo(User::class, 'destination');
    }

    /**
     * @return string
     */
    public function getDoctorAttribute() {
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
    public function getDoctorIDAttribute() {
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
    public function patient_scheme() {
        return $this->belongsTo(PatientInsurance::class, 'scheme');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requesting_institutions() {
        return $this->belongsTo(PartnerInstitution::class, 'requesting_institution');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function metas() {
        return $this->hasOne(VisitMeta::class, 'visit');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function destinations() {
        return $this->hasMany(VisitDestinations::class, 'visit');
    }

    public function drug_purchases() {
        return $this->hasMany(\Ignite\Inventory\Entities\InventoryBatchProductSales::class, 'id', 'visit');
    }

    public function external_doctors() {
        return $this->belongsTo(User::class, 'external_doctor');
    }

    public function wardsAssigned(){
        return $this->hasMany(WardAssigned::class, "visit_id");
    }


}
