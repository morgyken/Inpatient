<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $bed
 * @property mixed $ward
 * @property mixed $patients
 */
class Admission extends Model
{
    protected $fillable = [ 'patient_id', 'bed_id' , 'ip_number', 'ward_id', 'admitted_at', 'admitted_by'];

    protected $table ='admission';

    protected $cats = [
        'admission_notes' => 'array',
    ];

    protected $dates = 'admitted_at';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * a patient has many admissions
     */
    public function patients()
    {
        return $this->belongsTo(Patients::class, 'patient_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ward()
    {
        return $this->hasOne(Ward::class, 'ward_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function bed()
    {
        return $this->hasOne(Bed::class, 'bed_id');
    }


    /**
     * @return bool
     */
    public function admission_notes()
    {
        return $this->hasCast('admission_notes', 'longText');
    }


}
