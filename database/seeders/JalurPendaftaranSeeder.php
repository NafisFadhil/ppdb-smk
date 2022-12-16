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
                'biaya_pendaftaran' => 50000,
                'biaya_daftar_ulang' => 500000,
                'biaya_seragam' => 450000,
                'periode_akhir' => now()->setDay(7)->setMonth(4)->setYear(2023)->setTime(23,59,59,59),
            ],
            // Afirmasi
            [
                'jalur' => 'Afirmasi',
                'subjalur1' => null,
                'biaya_pendaftaran' => 0,
                'biaya_daftar_ulang' => 0,
                'biaya_seragam' => 0,
                'periode_akhir' => now()->setDay(19)->setMonth(4)->setYear(2023)->setTime(23,59,59,59),
            ],



            // Prestasi
            [
                'jalur' => 'Prestasi',
                'subjalur1' => null,
                'biaya_pendaftaran' => 0,
                'biaya_daftar_ulang' => 0,
                'biaya_seragam' => 450000,
                'periode_akhir' => now()->setDay(19)->setMonth(4)->setYear(2023)->setTime(23,59,59,59),
            ],

            // Prestasi Lanjutan
            [
                'jalur' => 'Prestasi',
                'subjalur1' => 'Kedinasan',
                'biaya_pendaftaran' => 0,
                'biaya_daftar_ulang' => 0,
                'biaya_seragam' => 450000,
                'periode_akhir' => now()->setDay(19)->setMonth(4)->setYear(2023)->setTime(23,59,59,59),
            ],

            [
                'jalur' => 'Prestasi',
                'subjalur1' => 'Non-Kedinasan',
                'biaya_pendaftaran' => 0,
                'biaya_daftar_ulang' => 0,
                'biaya_seragam' => 450000,
                'periode_akhir' => now()->setDay(19)->setMonth(4)->setYear(2023)->setTime(23,59,59,59),
            ],
            [
                'jalur' => 'Prestasi',
                'subjalur1' => 'Aktivis',
                'biaya_pendaftaran' => 0,
                'biaya_daftar_ulang' => 0,
                'biaya_seragam' => 450000,
                'periode_akhir' => now()->setDay(19)->setMonth(4)->setYear(2023)->setTime(23,59,59,59),
            ],
            [
                'jalur' => 'Prestasi',
                'subjalur1' => 'Bintang Kelas',
                'biaya_pendaftaran' => 0,
                'biaya_daftar_ulang' => 0,
                'biaya_seragam' => 450000,
                'periode_akhir' => now()->setDay(19)->setMonth(4)->setYear(2023)->setTime(23,59,59,59),
            ],
            [
                'jalur' => 'Prestasi',
                'subjalur1' => 'Tahfid Quran',
                'biaya_pendaftaran' => 0,
                'biaya_daftar_ulang' => 0,
                'biaya_seragam' => 450000,
                'periode_akhir' => now()->setDay(19)->setMonth(4)->setYear(2023)->setTime(23,59,59,59),
            ],
        ]);
    }
}
