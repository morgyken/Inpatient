<?php

namespace Ignite\Inpatient\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Ignite\Inpatient\Entities\BedType;

class BedTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $bedTypes = [
            ['name' => 'railed', 'description' => 'has roll-off guard'],
            ['name' => 'non-railed', 'description' => 'does not have roll-off guard'],
        ];

        foreach($bedTypes as $bedType)
        {
            BedType::create($bedType);
        }
    }
}
