<?php
namespace Ignite\Inpatient\Repositories;

use Ignite\Inpatient\Entities\Charge;

class ChargeRepository
{
    /*
    * Fetch all the wards from the database
    */
    public function all()
    {
        return Charge::all();
    }

    /*
    * Create a new ward
    */
    public function create($fields)
    {
        return Charge::create($fields);
    }

    /*
    * Delete a ward
    */
    public function delete($id)
    {
        return Charge::where('id', $id)->delete();
    }
}