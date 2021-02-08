<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTypeSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_type')->insert([
            'type' => 0,
            'name' => 'นักศึกษา'
        ]);

        DB::table('user_type')->insert([
            'type' => 1,
            'name' => 'บุคลากร'
        ]);

        DB::table('user_type')->insert([
            'type' => 2,
            'name' => 'Admin'
        ]);
    }
}
