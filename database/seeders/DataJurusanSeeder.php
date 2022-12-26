<?php

namespace Database\Seeders;

use App\Models\DataJurusan;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

// use Illuminate\Support\Facades\DB;

class DataJurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('data_jurusans')->insert([
            [
                "nama" => "Teknik Kendaraan Ringan",
                "slug" => "teknik-kendaraan-ringan",
                "singkatan" => 'tkr',
                'kode' => 'R'
            ],
            [
                "nama" => "Teknik Sepeda Motor",
                "slug" => "teknik-sepeda motor",
                "singkatan" => 'tsm',
                'kode' => 'T'
            ],
            [
                "nama" => "Teknik Komputer dan Jaringan",
                "slug" => "teknik-komputer-dan-jaringan",
                "singkatan" => 'tkj',
                'kode' => 'J'
            ],
            [
                "nama" => "Akuntansi",
                "slug" => "akuntansi",
                "singkatan" => 'akuntansi',
                'kode' => 'A'
            ],
            [
                "nama" => "Farmasi Klinis dan Komunitas",
                "slug" => "farmasi-klinis-dan-Komunitas",
                "singkatan" => 'fkk',
                'kode' => 'F'
            ],
        ]);
    }
}
