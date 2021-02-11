<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('configs')->insert([
            'description' => 'หน้าปก บทคัดย่อ และสารบัญ'
        ]);

        DB::table('configs')->insert([
            'description' => 'บทที่ 1'
        ]);

        DB::table('configs')->insert([
            'description' => 'บทที่ 2'
        ]);

        DB::table('configs')->insert([
            'description' => 'บทที่ 3'
        ]);

        DB::table('configs')->insert([
            'description' => 'บทที่ 4'
        ]);

        DB::table('configs')->insert([
            'description' => 'บทที่ 5'
        ]);

        DB::table('configs')->insert([
            'description' => 'รายการอ้างอิงและภาคผนวก'
        ]);
    }
}
