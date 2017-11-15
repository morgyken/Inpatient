<?php
namespace Ignite\Inpatient\Repositories;

use Ignite\Inpatient\Entities\Admission;

class AdmissionRepository
{
    /*
    * Persist a record into the database
    */
    public function create($fields)
    {
        return Admission::create($fields);
    }

    /*
    * Fethch all the admissions from the database
    */
    public function all()
    {
        return Admission::all();
    }
}