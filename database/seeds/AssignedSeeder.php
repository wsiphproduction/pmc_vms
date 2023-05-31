<?php

use Illuminate\Database\Seeder;

class AssignedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('assigned')->updateOrInsert([
            'id' => 1,
            'name' => 'PMC',
            'active' => 1
        ]);

        DB::table('assigned')->updateOrInsert([
            'id' => 2,
            'name' => 'Webpack',
            'active' => 1
        ]);


    }
}
