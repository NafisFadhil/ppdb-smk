<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jurusans')->insert(array(
            array(
                "nama" => "Teknik Kendaraan Ringan Otomotif",
                "singkatan" => "TKRO",
                "slug" => "teknik-kendaraan-ringan-otomotif",
            ),
            array(
                "nama" => "Teknik Bisnis dan Sepeda Motor",
                "singkatan" => "TBSM",
                "slug" => "Teknik-bisnis-dan-sepeda motor",
            ),
            array(
                "nama" => "Teknik Komputer dan Jaringan",
                "singkatan" => "TKJ",
                "slug" => "teknik-komputer-dan-jaringan",
            ),
            array(
                "nama" => "Akuntansi dan Keuangan Lembaga",
                "singkatan" => "AKL",
                "slug" => "akuntansi-dan-keuangan-lembaga",
            ),
            array(
                "nama" => "Farmasi Klinis dan Kesehatan",
                "singkatan" => "FKK",
                "slug" => "farmasi-klinis-dan-kesehatan",
            ),
        ));        
    }
}
