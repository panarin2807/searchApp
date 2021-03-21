<?php

namespace Database\Seeders;

use App\Models\Config;
use App\Models\Project;
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
        $project = Project::all();
        $config = Config::all();

        DB::table('project_files')->insert([
            'project_id' => $project[0]->id,
            'config_id' => $config[0]->id,
            'value' => 'file/2021/1/front.pdf'
        ]);

        DB::table('project_files')->insert([
            'project_id' => $project[0]->id,
            'config_id' => $config[1]->id,
            'value' => 'file/2021/1/ch_1.pdf'
        ]);

        DB::table('project_files')->insert([
            'project_id' => $project[0]->id,
            'config_id' => $config[2]->id,
            'value' => 'file/2021/1/ch_2.pdf'
        ]);

        DB::table('project_files')->insert([
            'project_id' => $project[0]->id,
            'config_id' => $config[3]->id,
            'value' => 'file/2021/1/ch_3.pdf'
        ]);

        DB::table('project_files')->insert([
            'project_id' => $project[0]->id,
            'config_id' => $config[4]->id,
            'value' => 'file/2021/1/ch_4.pdf'
        ]);

        DB::table('project_files')->insert([
            'project_id' => $project[0]->id,
            'config_id' => $config[5]->id,
        ]);

        DB::table('project_files')->insert([
            'project_id' => $project[0]->id,
            'config_id' => $config[6]->id,
        ]);
    }
}
