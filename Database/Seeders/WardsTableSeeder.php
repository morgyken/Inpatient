<?php

namespace Ignite\Inpatient\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory;
use Ignite\Inpatient\Entities\Ward;

class WardsTableSeeder extends Seeder
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
                'name' => $faker->streetName,
                'gender' =>  $faker->randomElement(['male' ,'female', 'other']),
                'age_group' =>  $faker->randomElement(['adult', 'children']),
                'insurance_cost' => $faker->numberBetween($min = 2000, $max = 2500),
                'cash_cost' => $faker->numberBetween($min = 1000, $max = 1500),
            ];

            Ward::create($record);
        }
    }
}
