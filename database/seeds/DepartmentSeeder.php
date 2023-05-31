<?php

use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('department')->updateOrInsert([
            'id' => 1,
            'name' => 'ECS Division'
        ]);

        DB::table('department')->updateOrInsert([
            'id' => 2,
            'name' => 'ELECETRICAL SERVICES'
        ]);

        DB::table('department')->updateOrInsert([
            'id' => 3,
            'name' => 'ICT/IT'
        ]);

        DB::table('department')->updateOrInsert([
            'id' => 4,
            'name' => 'MINCE MCD'
        ]);

        DB::table('department')->updateOrInsert([
            'id' => 5,
            'name' => 'ECS-civilworks'
        ]);

        DB::table('department')->updateOrInsert([
            'id' => 6,
            'name' => 'ENVIRONMENT'
        ]);

        DB::table('department')->updateOrInsert([
            'id' => 7,
            'name' => 'ESD'
        ]);

        DB::table('department')->updateOrInsert([
            'id' => 8,
            'name' => 'EXECUTIVE'
        ]);

        DB::table('department')->updateOrInsert([
            'id' => 9,
            'name' => 'EXPLORATION'
        ]);

        DB::table('department')->updateOrInsert([
            'id' => 10,
            'name' => 'GEOLOGY'
        ]);

        DB::table('department')->updateOrInsert([
            'id' => 11,
            'name' => 'GSD'
        ]);

        DB::table('department')->updateOrInsert([
            'id' => 12,
            'name' => 'MASABONG'
        ]);

        DB::table('department')->updateOrInsert([
            'id' => 13,
            'name' => 'MEDICAL'
        ]);

        DB::table('department')->updateOrInsert([
            'id' => 14,
            'name' => 'MILL'
        ]);

        DB::table('department')->updateOrInsert([
            'id' => 15,
            'name' => 'MILL MCD'
        ]);

        DB::table('department')->updateOrInsert([
            'id' => 16,
            'name' => 'MILL OPERATION'
        ]);

        DB::table('department')->updateOrInsert([
            'id' => 17,
            'name' => 'MILL TSF'
        ]);

        DB::table('department')->updateOrInsert([
            'id' => 18,
            'name' => 'Mine - E15'
        ]);

        DB::table('department')->updateOrInsert([
            'id' => 19,
            'name' => 'Mine - Environment'
        ]);
    }
}
