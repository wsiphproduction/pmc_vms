<?php

use Illuminate\Database\Seeder;

class VehicleRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vehicle_request')->updateOrInsert([
            'id' => 50,
            'date_needed' => '2020-09-29 00:00:00',
            'purpose' => 'test',
            'costcode' => '1654165',
            'status' => 'New Request',
            'dept_id' => '19'
        ]);

        DB::table('vehicle_request')->updateOrInsert([
            'id' => 51,
            'date_needed' => '2020-09-29 00:00:00',
            'purpose' => 'test',
            'costcode' => '16542312',
            'status' => 'New Request',
            'dept_id' => '19'
        ]);
    }
}
