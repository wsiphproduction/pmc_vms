<?php

use Illuminate\Database\Seeder;

class MechanicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('mechanics')->updateOrInsert([
            'id' => 1,
            'name' => 'ERMEO'
        ]);

        DB::table('mechanics')->updateOrInsert([
            'id' => 2,
            'name' => 'PELIGRO'
        ]);

        DB::table('mechanics')->updateOrInsert([
            'id' => 3,
            'name' => 'TIMKANG'
        ]);

    }
}
