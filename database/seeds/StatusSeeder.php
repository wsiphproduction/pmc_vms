<?php

use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('unit_status')->updateOrInsert([
            'id' => 1,
            'status' => 'IN-PROGRESS'
        ]);

        DB::table('unit_status')->updateOrInsert([
            'id' => 2,
            'status' => 'COMPLETED'
        ]);

        DB::table('unit_status')->updateOrInsert([
            'id' => 3,
            'status' => 'CANCELLED'
        ]);
    }
}
