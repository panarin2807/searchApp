<?php

namespace Database\Seeders;

use App\Models\ProjectRela;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PrefixSeed::class,
            UserSeed::class,
            ConfigSeeder::class,
            UserTypeSeed::class,
            GroupSeeder::class,
            CurriculumSeeder::class,
            ProjectSeed::class,
            ProjectRelaSeed::class,
            ProjectFileSeeder::class,
        ]);
    }
}
