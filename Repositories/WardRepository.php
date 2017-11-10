<?php
namespace Ignite\Inpatient\Repositories;

use Ignite\Inpatient\Entities\Ward;

class WardRepository
{
    /*
    * Fetch all the wards from the database
    */
    public function all()
    {
        return Ward::with(['beds'])->get();
    }

    /*
    * Create a new ward
    */
    public function create($fields)
    {

    }

    /*
    * Attach a abew to a ward
    */
    public function attachBed()
    {
        
    }
}