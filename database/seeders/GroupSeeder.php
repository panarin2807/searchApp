<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('groups')->insert([
            'name' => 'Stat Analysis, Regression, Factor Analysis',
            'detail' => 'Stat Analysis, Regression, Factor Analysis',
        ]);

        DB::table('groups')->insert([
            'name' => 'Forecasting, Inventory, QC',
            'detail' => 'Forecasting, Inventory, QC',
        ]);

        DB::table('groups')->insert([
            'name' => 'Stat Theory, Multivariate, Risk',
            'detail' => 'Stat Theory, Multivariate, Risk',
        ]);

        DB::table('groups')->insert([
            'name' => 'System Analysis, Database, Data warehouse, Machine Learning, Data Mining',
            'detail' => 'System Analysis, Database, Data warehouse, Machine Learning, Data Mining',
        ]);
    }
}
