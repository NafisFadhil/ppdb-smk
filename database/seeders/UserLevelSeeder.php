<?php

namespace Database\Seeders;

use App\Metadata\UserLevel as MetadataUserLevel;
use App\Models\UserLevel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_levels')->insert(UserLevel::$level);
    }
}
