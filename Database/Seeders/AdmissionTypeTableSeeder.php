<?php

namespace Ignite\Inpatient\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Ignite\Inpatient\Entities\AdmissionType;

class AdmissionTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        AdmissionType::create([
            'name' => 'General Surgery', 'deposit' => 100000, 'description' => 'general surgery'
        ]);
    }
}
