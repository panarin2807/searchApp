<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'fname' => 'Student',
            'lname' => 'Test',
            'email' => 'student@gmail.com',
            'username' => 'student',
            'password' => Hash::make('123456'),
            'type' => 0
        ]);

        DB::table('users')->insert([
            'fname' => 'Teacher',
            'lname' => 'Test',
            'email' => 'teacher@gmail.com',
            'username' => 'teacher',
            'password' => Hash::make('123456'),
            'type' => 1
        ]);

        DB::table('users')->insert([
            'fname' => 'Admin',
            'lname' => 'Admin',
            'email' => 'admin@gmail.com',
            'username' => 'adminadmin',
            'password' => Hash::make('123456'),
            'type' => 2
        ]);
    }
}
