<?php

use Illuminate\Database\Seeder;

class FuelTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fuel_types')->updateOrInsert([
            'id' => 1,
            'name' => 'Premium'
        ]);

        DB::table('fuel_types')->updateOrInsert([
            'id' => 2,
            'name' => 'Unleaded'
        ]);
    }
}
