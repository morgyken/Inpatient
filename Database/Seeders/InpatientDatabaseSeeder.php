<?php

namespace Ignite\Inpatient\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class InpatientDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(BedTypesTableSeeder::class);

        $this->call(WardsTableSeeder::class);

        $this->call(BedsTableSeeder::class);

        $this->call(ChargesTableSeeder::class);

        $this->call(AdmissionTypeTableSeeder::class);

        $this->call(ChargeSheetTypesTableSeeder::class);
    }
}
