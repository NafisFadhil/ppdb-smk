<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
                "nama" => "Teknik Kendaraan Ringan Otomotif",
                "slug" => "teknik-kendaraan-ringan-otomotif",
                "singkatan" => 'tkro',
                'kode' => 'R'
            ],
            [
                "nama" => "Teknik Bisnis dan Sepeda Motor",
                "slug" => "teknik-bisnis-dan-sepeda motor",
                "singkatan" => 'tbsm',
                'kode' => 'T'
            ],
            [
                "nama" => "Teknik Komputer dan Jaringan",
                "slug" => "teknik-komputer-dan-jaringan",
                "singkatan" => 'tkj',
                'kode' => 'J'
            ],
            [
                "nama" => "Akuntansi dan Keuangan Lembaga",
                "slug" => "akuntansi-dan-keuangan-lembaga",
                "singkatan" => 'akl',
                'kode' => 'A'
            ],
            [
                "nama" => "Farmasi Klinis dan Kesehatan",
                "slug" => "farmasi-klinis-dan-kesehatan",
                "singkatan" => 'fkk',
                'kode' => 'F'
            ],
        ]);
    }
}
