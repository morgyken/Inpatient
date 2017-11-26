<?php

namespace Ignite\Inpatient\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Ignite\Inpatient\Entities\ChargeSheetType;

class ChargeSheetTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $chargeSheetTypes = array(
            ['name' => 'general', 'description' => 'charges made on the initial admission or treatment process'],
            ['name' => 'prescriptions', 'description' => 'charges on prescriptions'],
            ['name' => 'procedures', 'description' => 'charges on procedures done on patient'],
        );

        foreach($chargeSheetTypes as $record)
        {
            ChargeSheetType::create($record);
        }
    }
}
