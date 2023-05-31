<?php

use Illuminate\Database\Seeder;

class DispatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dispatch')->updateOrInsert([
            'id' => 50,
            'unitId' => 1,
            'deptId' => 19,
            'tripTicket' => 'TN-000050',
            'destination' => 'Davao',
            'odometer_start' => '20',
            'odometer_end' => '15',
            'fuel_added_type' => 1,
            'request_id' => 50,
            'status' => 'Complete',
            'RQ' => 12,
            'itemCode' => 'AR-12',
            'uom' => 'km',
            'vehicle_cost_code' => 'VH-0012',
            'do' => '2020-09-11 00:00:00',
            'app_date' => '2020-09-29 00:00:00'
        ]);

        DB::table('dispatch')->updateOrInsert([
            'id' => 51,
            'unitId' => 1,
            'deptId' => 19,
            'tripTicket' => 'TN-000051',
            'destination' => 'Davao',
            'odometer_start' => '20',
            'odometer_end' => '15',
            'fuel_added_type' => 1,
            'request_id' => 51,
            'status' => 'Complete',
            'RQ' => 12,
            'itemCode' => 'AR-12',
            'uom' => 'km',
            'vehicle_cost_code' => 'VH-0012',
            'do' => '2020-09-11 00:00:00',
            'app_date' => '2020-09-29 00:00:00'
        ]);
    }
}
