<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        DB::table('configs')->insert([
            [
                'key' => 'nama_sekolah',
                'value' => 'SMK Muhammadiyah Bligo'
            ],
            [
                'key' => 'alamat_sekolah',
                'value' => 'Desa Sapugarut Gg. 7, Kec. Buaran, Kabupaten Pekalongan, Jawa Tengah 51171'
            ],
            [
                'key' => 'tahun_ppdb',
                'value' => '2023'
            ],
        ]);
    }
}
