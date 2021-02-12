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
        ];

        foreach ($prefixes as $value) {
            DB::table('prefixes')->insert([
                'name' => $value
            ]);
        }
    }
}
