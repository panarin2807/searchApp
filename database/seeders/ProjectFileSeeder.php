<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('project_files')->insert([
            'project_id' => 1,
            'config_id' => 1,
            'value' => 'file/1/2021/02/front.pdf'
        ]);

        DB::table('project_files')->insert([
            'project_id' => 1,
            'config_id' => 2,
            'value' => 'file/1/2021/02/ch_1.pdf'
        ]);

        DB::table('project_files')->insert([
            'project_id' => 1,
            'config_id' => 3,
            'value' => 'file/1/2021/02/ch_2.pdf'
        ]);

        DB::table('project_files')->insert([
            'project_id' => 1,
            'config_id' => 4,
            'value' => 'file/1/2021/02/ch_3.pdf'
        ]);

        DB::table('project_files')->insert([
            'project_id' => 1,
            'config_id' => 5,
            'value' => 'file/1/2021/02/ch_4.pdf'
        ]);

        DB::table('project_files')->insert([
            'project_id' => 1,
            'config_id' => 6,
            'value' => 'file/1/2021/02/ch_5.pdf'
        ]);

        DB::table('project_files')->insert([
            'project_id' => 1,
            'config_id' => 7,
            'value' => 'file/1/2021/02/back.pdf'
        ]);
    }
}
