<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inpatient\Entities\InsuranceMaximumAmount
 *
 * @property int $id
 * @property int $admission_request_id
 * @property int $scheme_id
 * @property float $maximum_amount
 * @property string $authorization_letter_url
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\InsuranceMaximumAmount whereAdmissionRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\InsuranceMaximumAmount whereAuthorizationLetterUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\InsuranceMaximumAmount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\InsuranceMaximumAmount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\InsuranceMaximumAmount whereMaximumAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\InsuranceMaximumAmount whereSchemeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inpatient\Entities\InsuranceMaximumAmount whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InsuranceMaximumAmount extends Model
{
    protected $fillable = [
        'admission_request_id', 'scheme_id', 'maximum_amount', 'authorization_letter_url'
    ];

    protected $table = "inpatient_insurance_maximum_amounts";


}
