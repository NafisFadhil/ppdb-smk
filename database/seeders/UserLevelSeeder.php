<?php

namespace Database\Seeders;

use App\Metadata\UserLevel as MetadataUserLevel;
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
        DB::table('user_levels')->insert([
            // Level Peserta PPDB
            ['id' => 1, 'name' => 'pendaftar', 'desc' => 'Peserta PPDB sudah melakukan pendaftaran.'],
            ['id' => 2, 'name' => 'daftar-ulang', 'desc' => 'Peserta PPDB sudah melakukan daftar ulang.'],
            ['id' => 3, 'name' => 'seragam', 'desc' => 'Peserta PPDB sudah melunasi biaya seragam.'],
            // Level Administrator
            ['id' => 4, 'name' => 'admin-pendaftaran', 'desc' => 'Panitia PPDB bagian pendaftaran.'],
            ['id' => 5, 'name' => 'admin-daftar-ulang', 'desc' => 'Panitia PPDB bagian daftar ulang.'],
            ['id' => 6, 'name' => 'admin-seragam', 'desc' => 'Panitia PPDB bagian seragam.'],
            ['id' => 7, 'name' => 'super-admin', 'desc' => 'Top Level Privilege'],
        ]);
    }
}
