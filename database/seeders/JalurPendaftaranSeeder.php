<?php

namespace Database\Seeders;

use App\Models\JalurPendaftaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JalurPendaftaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JalurPendaftaran::create([
            // Umum
            [
                'jalur' => 'Umum',
                'subjalur1' => null,
                'subjalur2' => null,
                'subjalur3' => null,
                'biaya_pendaftaran' => 50000,
                'biaya_daftar_ulang' => 500000,
                'biaya_bonus' => 0,
            ],
            // Bintang Kelas
            [
                'jalur' => 'Bintang Kelas',
                'subjalur1' => null,
                'subjalur2' => null,
                'subjalur3' => null,
                'biaya_pendaftaran' => 0,
                'biaya_daftar_ulang' => 500000,
                'biaya_bonus' => 0,
            ],
            // Bidik Misi
            [
                'jalur' => 'Bidik Misi',
                'subjalur1' => null,
                'subjalur2' => null,
                'subjalur3' => null,
                'biaya_pendaftaran' => 0,
                'biaya_daftar_ulang' => 0,
                'biaya_bonus' => 0,
            ],
            // Bidik Misi Lanjutan
            [
                'jalur' => 'Bidik Misi',
                'subjalur1' => 'Prestasi',
                'subjalur2' => 'Kedinasan',
                'subjalur3' => 'Nasional',
                'biaya_pendaftaran' => 0,
                'biaya_daftar_ulang' => 0,
                'biaya_bonus' => 600000,
            ],
            [
                'jalur' => 'Bidik Misi',
                'subjalur1' => 'Prestasi',
                'subjalur2' => 'Kedinasan',
                'subjalur3' => 'Provinsi',
                'biaya_pendaftaran' => 0,
                'biaya_daftar_ulang' => 0,
                'biaya_bonus' => 400000,
            ],
            [
                'jalur' => 'Bidik Misi',
                'subjalur1' => 'Prestasi',
                'subjalur2' => 'Kedinasan',
                'subjalur3' => 'Kabupaten',
                'biaya_pendaftaran' => 0,
                'biaya_daftar_ulang' => 0,
                'biaya_bonus' => 200000,
            ],

            [
                'jalur' => 'Bidik Misi',
                'subjalur1' => 'Prestasi',
                'subjalur2' => 'Non-Kedinasan',
                'subjalur3' => 'Nasional/Provinsi',
                'biaya_pendaftaran' => 0,
                'biaya_daftar_ulang' => 0,
                'biaya_bonus' => 0,
            ],
            [
                'jalur' => 'Bidik Misi',
                'subjalur1' => 'Prestasi',
                'subjalur2' => 'Non-Kedinasan',
                'subjalur3' => 'Karesidenan/Kabupaten',
                'biaya_pendaftaran' => 0,
                'biaya_daftar_ulang' => 500000,
                'biaya_bonus' => 0,
            ],

            [
                'jalur' => 'Bidik Misi',
                'subjalur1' => 'Kader Berprestasi',
                'subjalur2' => null,
                'subjalur3' => null,
                'biaya_pendaftaran' => 0,
                'biaya_daftar_ulang' => 0,
                'biaya_bonus' => 0,
            ],
            [
                'jalur' => 'Bidik Misi',
                'subjalur1' => 'Tahfid Quran',
                'subjalur2' => null,
                'subjalur3' => null,
                'biaya_pendaftaran' => 0,
                'biaya_daftar_ulang' => 0,
                'biaya_bonus' => 0,
            ],
        ]);
    }
}
