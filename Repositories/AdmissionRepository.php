<?php
namespace Ignite\Inpatient\Repositories;

use Ignite\Inpatient\Entities\Admission;

class AdmissionRepository
{
    /*
    * Get an admission by ID
    */
    public function find($admissionId)
    {
        return Admission::findOrFail($admissionId);
    }

    /*
    * Persist a record into the database
    */
    public function create($fields)
    {
        
        return Admission::firstOrCreate($fields);
    }

    /*
    * Fethch all the admissions from the database
    */
    public function all()
    {
        return Admission::orderBy('created_at', 'DESC')->get();
    }
}