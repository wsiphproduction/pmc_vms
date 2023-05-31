<?php

use Illuminate\Database\Seeder;

class PreventiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('repair_preventive')->updateOrInsert([
            'id' => 1,
            'name' => 'Inspections'
        ]);

        DB::table('repair_preventive')->updateOrInsert([
            'id' => 2,
            'name' => 'Repair and Replace'
        ]);

        DB::table('repair_preventive')->updateOrInsert([
            'id' => 3,
            'name' => 'Service and Lube'
        ]);
    }
}
