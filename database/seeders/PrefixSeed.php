<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrefixSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $prefixes = [
            'นาย',
            'นาง',
            'นางสาว',
            'อาจารย์',
            'ผู้ช่วยศาสตราจารย์',
            'รองศาสตราจารย์',
            'ศาสตราจารย์',
        ];

        foreach ($prefixes as $K => $value) {
            DB::table('prefixes')->insert([
                'id' => $K+1,
                'name' => $value
            ]);
        }
    }
}
