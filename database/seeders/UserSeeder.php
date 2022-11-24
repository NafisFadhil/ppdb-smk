<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            ['name' => 'Admin Pendaftaran', 'username' => 'admin-pendaftaran', 'password' => Hash::make('admin123'), 'level_id' => 2],
            ['name' => 'Admin Daftar Ulang', 'username' => 'admin-daftar-ulang', 'password' => Hash::make('admin123'), 'level_id' => 3],
            ['name' => 'Admin Seragam', 'username' => 'admin-seragam', 'password' => Hash::make('admin123'), 'level_id' => 4],
            ['name' => 'Super Admin', 'username' => 'super-admin', 'password' => Hash::make('admin123'), 'level_id' => 5],
        ]);
    }
}
