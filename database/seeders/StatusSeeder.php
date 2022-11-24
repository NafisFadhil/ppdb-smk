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
        $level = ['Pendaftar', 'Daftar Ulang', 'Seragam'];
        $sublevel = [
            'Menunggu Input Pembayaran',
            'Menunggu Pembayaran Siswa',
            'Menunggu Verifikasi Admin',
        ];
        $status = [
            'Menunggu admin menginputkan nominal pembayaran.',
            'Menunggu siswa melakukan pembayaran biaya pendaftaran.',
            'Menunggu admin melakukan verifikasi data siswa.',
        ];

        $seeds = [];
        foreach ($level as $lvl) {
            for ($i = 0; $i < count($sublevel); $i++) {
                $seeds[] = [
                    'level' => $lvl,
                    'sublevel' => $sublevel[$i],
                    'desc' => $status[$i]
                ];
            }
        }
        
        DB::table('statuses')->insert($seeds);
    }
}
