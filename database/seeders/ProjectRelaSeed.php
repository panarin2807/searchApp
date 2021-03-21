<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
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
        $project = Project::all();
        $user = User::all();
        //
        DB::table('project_relas')->insert([
            'user_id' => $user[0]->id,
            'project_id' => $project[0]->id,
        ]);

        DB::table('project_relas')->insert([
            'user_id' => $user[1]->id,
            'project_id' => $project[0]->id,
        ]);

        DB::table('project_relas')->insert([
            'user_id' => $user[2]->id,
            'project_id' => $project[0]->id,
        ]);
    }
}
