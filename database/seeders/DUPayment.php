<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DUPayment extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dupayments')->insert([
            ['jalur_pendaftaran' => 'Umum', 'payment' => 0],
            ['jalur_pendaftaran' => 'Prestasi', 'payment' => 0],
            ['jalur_pendaftaran' => 'Bidikmisi', 'payment' => 0],
        ]
        );
    }
}
