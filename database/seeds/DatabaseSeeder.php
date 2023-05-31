<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        // $this->call(DepartmentSeeder::class);
        // $this->call(DowntimeSeeder::class);
        // $this->call(AssignedSeeder::class);
        // $this->call(BreakdownSeeder::class);
        // $this->call(MechanicSeeder::class);
        // $this->call(PreventiveSeeder::class);
        // $this->call(UnitSeeder::class);
        // $this->call(StatusSeeder::class);
        // $this->call(DriverSeeder::class);
        // $this->call(FuelTypeSeeder::class);
        // $this->call(VehicleRequestSeeder::class);
        // $this->call(DispatchSeeder::class);
        $this->call(DestinationSeeder::class);
    }
}
