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
                'sublevel' => 'Menunggu Input Pembayaran',
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
                'level' => 'Daftar Ulang',
                'sublevel' => 'Menunggu Pengisian Formulir',
                'desc' => 'Menunggu siswa mengisi formulir daftar ulang.',
            ],
            [
                'level' => 'Daftar Ulang',
                'sublevel' => 'Menunggu Input Pembayaran',
                'desc' => 'Menunggu admin menginputkan nominal biaya daftar ulang.',
            ],
            [
                'level' => 'Daftar Ulang',
                'sublevel' => 'Menunggu Pembayaran Siswa',
                'desc' => 'Menunggu siswa melakukan pembayaran.',
            ],
            [
                'level' => 'Daftar Ulang',
                'sublevel' => 'Menunggu Verifikasi Admin',
                'desc' => 'Menunggu admin melakukan verifikasi.',
            ],
            [
                'level' => 'Seragam',
                'sublevel' => 'Menunggu Input Pembayaran',
                'desc' => 'Menunggu admin menginputkan nominal biaya seragam.',
            ],
            [
                'level' => 'Seragam',
                'sublevel' => 'Menunggu Pembayaran Siswa',
                'desc' => 'Menunggu siswa melakukan pembayaran.',
            ],
            [
                'level' => 'Seragam',
                'sublevel' => 'Menunggu Verifikasi Admin',
                'desc' => 'Menunggu admin melakukan verifikasi.',
            ],
            [
                'level' => 'Lulus',
                'sublevel' => 'Sudah Diterima',
                'desc' => 'Siswa telah menyelesaikan tahapan PPDB Online',
            ],
        ]);
    }
}
