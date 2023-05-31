<?php

use Illuminate\Database\Seeder;

class VehicleRequestStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vehicle_request_status')->updateOrInsert([
            'id' => 1,
            'name' => 'New Request'
        ]);
    }
}
