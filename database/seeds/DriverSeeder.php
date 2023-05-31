<?php

use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('drivers')->updateOrInsert([
            'id' => 1,
            'driver_name' => 'John Doe'
        ]);

        DB::table('drivers')->updateOrInsert([
            'id' => 2,
            'driver_name' => 'Jane Doe'
        ]);
    }
}
