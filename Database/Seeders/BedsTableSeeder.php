<?php

namespace Ignite\Inpatient\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory;
use Ignite\Inpatient\Entities\Bed;
use Ignite\Inpatient\Entities\Ward;
use Ignite\Inpatient\Entities\BedType;

class BedsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        for($start=0; $start < 10; $start++)
        {
            $faker = Factory::create();

            $record =  [
                'number' => $faker->numberBetween($min = 1, $max = 50),
                'ward_id' => Ward::inRandomOrder()->first()->id,
                'bed_type_id' => BedType::inRandomOrder()->first()->id,
            ];

            Bed::create($record);
        }
    }
}
