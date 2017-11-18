<?php
namespace Ignite\Inpatient\Repositories;

use Ignite\Inpatient\Entities\Charge;

class ChargeRepository
{
    protected $charge;

    /*
    * Fetch all the wards from the database
    */
    public function all()
    {
        return Charge::all();
    }

    /*
    * Create a new charge
    */
    public function create($fields)
    {
        $this->charge = Charge::create($fields);

        return $this;
    }

    /*
    * Sync a charge with wards
    */
    public function syncWards($wards)
    {
        $this->charge->wards()->attach($wards);

        return $this->charge;
    }

    /*
    * Get the charges by the type
    */
    public function getChargesByType($type)
    {
        return Charge::where('type', $type)->get();
    }
}