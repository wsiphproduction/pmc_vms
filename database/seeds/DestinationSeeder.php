<?php

use Illuminate\Database\Seeder;

class DestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('destinations')->updateOrInsert([
            'name' => 'Sarangani'
        ]);

        DB::table('destinations')->updateOrInsert([
            'name' => 'Davao'
        ]);

        DB::table('destinations')->updateOrInsert([
            'name' => 'Tagum'
        ]);

        DB::table('destinations')->updateOrInsert([
            'name' => 'Panabo'
        ]);
    }
}
