<?php

namespace Ignite\Inpatient\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Ignite\Inpatient\Entities\Ward;
use Ignite\Inpatient\Entities\Charge;

class ChargesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $charges = array(
            ['name' => 'nursing', 'cost' => 500, 'type' => 'recurring'],

            ['name' => 'admission pack', 'cost' => 2200, 'type' => 'once']
        );

        foreach($charges as $charge)
        {
            $wardIds = Ward::orderByRaw('RAND()')->take(rand(1, 4))->get()->pluck('id')->toArray();
            
            Charge::create($charge)->wards()->attach($wardIds);
        }
    }
}
