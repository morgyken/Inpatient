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
        $wards = Ward::with(['beds'])->get();

        return $wards;
    }

    /*
    * Create a new ward
    */
    public function create($fields)
    {
        return Ward::create($fields);
    }

    /*
    * Delete a ward
    */
    public function delete($id)
    {
        return Ward::where('id', $id)->delete();
    }
}