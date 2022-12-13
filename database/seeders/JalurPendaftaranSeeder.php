<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JalurPendaftaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jalur_pendaftarans')->insert([
            // Umum
            [
                'jalur' => 'Umum',
                'subjalur1' => null,
                'subjalur2' => null,
                'biaya_pendaftaran' => 50000,
                'biaya_daftar_ulang' => 500000,
                'biaya_seragam' => 500000,
            ],
            // Bintang Kelas
            [
                'jalur' => 'Bintang Kelas',
                'subjalur1' => null,
                'subjalur2' => null,
                'biaya_pendaftaran' => 0,
                'biaya_daftar_ulang' => 500000,
                'biaya_seragam' => 500000,
            ],
            // Bidik Misi
            [
                'jalur' => 'Bidik Misi',
                'subjalur1' => null,
                'subjalur2' => null,
                'biaya_pendaftaran' => 0,
                'biaya_daftar_ulang' => 0,
                'biaya_seragam' => 0,
            ],

            // Bidik Misi Lanjutan
            [
                'jalur' => 'Bidik Misi',
                'subjalur1' => 'Prestasi',
                'subjalur2' => 'Kedinasan',
                'biaya_pendaftaran' => 0,
                'biaya_daftar_ulang' => 0,
                'biaya_seragam' => 0,
            ],

            [
                'jalur' => 'Bidik Misi',
                'subjalur1' => 'Prestasi',
                'subjalur2' => 'Non-Kedinasan',
                'biaya_pendaftaran' => 0,
                'biaya_daftar_ulang' => 0,
                'biaya_seragam' => 0,
            ],

            [
                'jalur' => 'Bidik Misi',
                'subjalur1' => 'Umsida Yatim Piatu',
                'subjalur2' => null,
                'biaya_pendaftaran' => 0,
                'biaya_daftar_ulang' => 0,
                'biaya_seragam' => 0,
            ],
            [
                'jalur' => 'Bidik Misi',
                'subjalur1' => 'Tahfid Quran',
                'subjalur2' => null,
                'biaya_pendaftaran' => 0,
                'biaya_daftar_ulang' => 0,
                'biaya_seragam' => 0,
            ],
        ]);
    }
}
