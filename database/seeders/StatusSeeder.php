<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statuses')->insert([
            [
                'level' => 'Pendaftar',
                'sublevel' => 'Menunggu Input Tagihan',
                'desc' => 'Menunggu admin menginputkan nominal biaya pendaftaran.',
            ],
            [
                'level' => 'Pendaftar',
                'sublevel' => 'Menunggu Pembayaran Siswa',
                'desc' => 'Menunggu siswa melakukan pembayaran.',
            ],
            [
                'level' => 'Pendaftar',
                'sublevel' => 'Menunggu Verifikasi Admin',
                'desc' => 'Menunggu admin melakukan verifikasi.',
            ],
            [
                'level' => 'Daftar Ulang & Seragam',
                'sublevel' => 'Menunggu Input Tagihan',
                'desc' => 'Menunggu admin menginputkan nominal biaya daftar ulang dan seragam.',
            ],
            [
                'level' => 'Daftar Ulang & Seragam',
                'sublevel' => 'Menunggu Transaksi Pembayaran',
                'desc' => 'Menunggu siswa melakukan pembayaran dan verifikasi admin.',
            ],
            [
                'level' => 'Pendataan',
                'sublevel' => 'Menunggu Verifikasi Pendataan',
                'desc' => 'Menunggu admin memeriksa kelengkapan identitas.',
            ],
            [
                'level' => 'Selesai PPDB',
                'sublevel' => 'Selesai Tahapan PPDB',
                'desc' => 'Siswa telah menyelesaikan tahapan PPDB Online.',
            ],
        ]);
    }
}
