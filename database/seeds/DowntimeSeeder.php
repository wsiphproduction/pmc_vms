<?php

use Illuminate\Database\Seeder;

class DowntimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('downtime')->updateOrInsert([
            'id' => 138,
            'unitID' => 1,
            'isScheduled' => '2',
            'downtimeCategory' => 'Accident',
            'repairType' => 'Brake System',
            'tdowntime' => 2,
            'assignedTo' => 'PMC',
            'status' => 'In-Progress',
            'reportedDate' => '2018-07-03',
            'active' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('downtime')->updateOrInsert([
            'id' => 135,
            'unitID' => 2,
            'isScheduled' => '1',
            'downtimeCategory' => 'Accident',
            'repairType' => 'Inspections',
            'assignedTo' => 'PMC',
            'tdowntime' => 1,
            'status' => 'In-Progress',
            'reportedDate' => '2018-07-03',
            'active' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('downtime')->updateOrInsert([
            'id' => 134,
            'unitID' => 3,
            'isScheduled' => '1',
            'downtimeCategory' => 'Corrective Maintenance',
            'repairType' => 'Repair and Replace',
            'assignedTo' => 'PMC',
            'tdowntime' => 1,
            'status' => 'In-Progress',
            'reportedDate' => '2018-07-03',
            'active' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('downtime')->updateOrInsert([
            'id' => 133,
            'unitID' => 4,
            'isScheduled' => '1',
            'downtimeCategory' => 'Corrective Maintenance',
            'repairType' => 'Service and Lube',
            'assignedTo' => 'PMC',
            'tdowntime' => 1,
            'status' => 'In-Progress',
            'reportedDate' => '2018-07-03',
            'active' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('downtime')->updateOrInsert([
            'id' => 132,
            'unitID' => 5,
            'downtimeCategory' => 'Preventive Maintenance',
            'isScheduled' => '2',
            'repairType' => 'Transmission System',
            'assignedTo' => 'PMC',
            'tdowntime' => 2,
            'status' => 'COMPLETED',
            'reportedDate' => '2018-07-03',
            'active' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('downtime')->updateOrInsert([
            'id' => 126,
            'unitID' => 6,
            'downtimeCategory' => 'Preventive Maintenance',
            'isScheduled' => '2',
            'repairType' => 'Engine System',
            'assignedTo' => 'PMC',
            'tdowntime' => 2,
            'status' => 'CANCELLED',
            'reportedDate' => '2018-07-03',
            'active' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('downtime')->updateOrInsert([
            'id' => 124,
            'unitID' => 7,
            'downtimeCategory' => 'Accident',
            'isScheduled' => '2',
            'repairType' => 'Clutch System',
            'assignedTo' => 'PMC',
            'tdowntime' => 2,
            'status' => 'COMPLETED',
            'reportedDate' => '2018-07-03',
            'active' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
    }
}
