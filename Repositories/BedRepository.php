<?php
namespace Ignite\Inpatient\Repositories;

use Ignite\Inpatient\Entities\Bed;

class BedRepository
{
    /*
    * Fetch all the wards from the database
    */
    public function all()
    {
        return Bed::all();
    }

    /*
    * Create a new ward
    */
    public function create($fields)
    {
        return Bed::create($fields);
    }

    /*
    * Delete a bed
    */
    public function delete($id)
    {
        return Bed::where('id', $id)->delete();
    }
}