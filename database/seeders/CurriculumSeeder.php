<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurriculumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('curricula')->insert([
            'name' => 'สถิติ'
        ]);

        DB::table('curricula')->insert([
            'name' => 'สารสนเทศสถิติ'
        ]);
    }
}
