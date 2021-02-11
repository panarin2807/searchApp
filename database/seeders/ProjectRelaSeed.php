<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectRelaSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('project_relas')->insert([
            'user_id' => 1,
            'project_id' => 1,
        ]);

        DB::table('project_relas')->insert([
            'user_id' => 2,
            'project_id' => 1,
        ]);

        DB::table('project_relas')->insert([
            'user_id' => 3,
            'project_id' => 1,
        ]);
    }
}
