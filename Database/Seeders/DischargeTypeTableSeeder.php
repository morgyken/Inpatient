<?php

namespace Ignite\Inpatient\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Ignite\Inpatient\Entities\DischargeType;

class DischargeTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $dischargeTypes = array(
            ['name' => 'Discharge Summary', 'description' => 'normal disharge on patient'],
            ['name' => 'Case Summary', 'description' => 'case discharge for patients that passed away']
        );

        foreach($dischargeTypes as $dischargeType)
        {
            DischargeType::create($dischargeType);
        }
    }
}
