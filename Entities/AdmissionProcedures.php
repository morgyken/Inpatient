<?php

namespace Ignite\Inpatient\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $admission
 */
class AdmissionProcedures extends Model
{
    protected $table = 'admission_procedures';
    protected $fillable = ['admission_id', 'admission_category_id', 'notes', 'performed_by'];
    protected $casts = [
        'notes' => 'array',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admission()
    {
        return $this->belongsTo(Admission::class, 'admission_id');
    }

    public function admission_categories()
    {
        return $this->belongsTo(AdmissionCategories::class, 'admission_category_id');
    }
}
