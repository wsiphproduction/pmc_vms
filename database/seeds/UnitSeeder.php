<?php

use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('unit')->updateOrInsert([
            'id' => 1,
            'type' => 'FORD (C01-Y537)'
        ]);

        DB::table('unit')->updateOrInsert([
            'id' => 2,
            'type' => 'FORD (C01-Y528)'
        ]);

        DB::table('unit')->updateOrInsert([
            'id' => 3,
            'type' => 'TELEHANDLER, MANITOU'
        ]);

        DB::table('unit')->updateOrInsert([
            'id' => 4,
            'type' => 'STRADA (LGZ-187)'
        ]);

        DB::table('unit')->updateOrInsert([
            'id' => 5,
            'type' => 'HILUX (YO-0974)'
        ]);

        DB::table('unit')->updateOrInsert([
            'id' => 6,
            'type' => 'HILUX (UGQ-179)'
        ]);

        DB::table('unit')->updateOrInsert([
            'id' => 7,
            'type' => 'DT # 15 (RJC-882)'
        ]);

        DB::table('unit')->updateOrInsert([
            'id' => 8,
            'type' => 'BOOMTRUCK (ACN-2936)'
        ]);

        DB::table('unit')->updateOrInsert([
            'id' => 9,
            'type' => 'BOOMTRUCK (JEW-548)'
        ]);
    }
}
