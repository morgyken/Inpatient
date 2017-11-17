<?php
namespace Ignite\Inpatient\Repositories;

use Ignite\Inpatient\Entities\BedType;

class BedTypeRepository
{
    /*
    * Fetch all the bed types from the database
    */
    public function all()
    {
        return BedType::all();
    }

    /*
    * Create a new bed type
    */
    public function create($fields)
    {
        return BedType::create($fields);
    }

    /*
    * Delete a bed type
    */
    public function delete($id)
    {
        return BedType::where('id', $id)->delete();
    }
    
}