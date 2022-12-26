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
        DB::table('user_levels')->insert([
            [
                'id' => 1,
                'name' => 'siswa',
                'label' => 'Siswa',
                'desc' => 'Siswa peserta PPDB.'
            ],
            [
                'id' => 2,
                'name' => 'admin-pendaftaran',
                'label' => 'Admin Pendaftaran',
                'desc' => 'Panitia PPDB bagian pendaftaran.'
            ],
            [
                'id' => 3,
                'name' => 'admin-duseragam',
                'label' => 'Admin Duseragam',
                'desc' => 'Panitia PPDB bagian daftar ulang dan seragam.'
            ],
            [
                'id' => 4,
                'name' => 'admin-pendataan',
                'label' => 'Admin Pendataan',
                'desc' => 'Panitia PPDB bagian verifikasi data siswa.'
            ],
            [
                'id' => 5,
                'name' => 'super-admin',
                'label' => 'Super Admin',
                'desc' => 'Top Level Privilege'
            ],
        ]);
    }
}
