<?php

use Illuminate\Database\Seeder;

use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $username = 'test';

        $user = User::where('email', 'testaccount@mail.com')->first();

        if(isset($user)){
            $user->delete();
        }

        DB::table('users')->updateOrInsert([
            'fullName' => $username,
            'email' => 'testaccount@mail.com',
            'domain' => $username,
            'dpassword' => bcrypt($username),
            'isLocked' => 0,
            'isApprover' => 1,
            'dept' => 1,
            'role' => 'admin',
            'active' => 1,
            'isDepartment' => 1
        ]);
    }
}
