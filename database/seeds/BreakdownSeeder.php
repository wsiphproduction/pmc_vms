<?php

use Illuminate\Database\Seeder;

class BreakdownSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('repair_breakdown')->updateOrInsert([
            'id' => 1,
            'name' => 'Brake System'
        ]);

        DB::table('repair_breakdown')->updateOrInsert([
            'id' => 2,
            'name' => 'Clutch System'
        ]);

        DB::table('repair_breakdown')->updateOrInsert([
            'id' => 3,
            'name' => 'Engine System'
        ]);

        DB::table('repair_breakdown')->updateOrInsert([
            'id' => 4,
            'name' => 'Primary Function'
        ]);

        DB::table('repair_breakdown')->updateOrInsert([
            'id' => 5,
            'name' => 'Transmission System'
        ]);
    }
}
