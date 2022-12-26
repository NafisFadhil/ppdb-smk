<?php

namespace Database\Seeders;

use App\Models\Seragam;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataSeragamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ukuran = json_encode(['M','L','XL']);
        DB::table('data_seragams')->insert([
            ['seragam' => 'wearpack', 'ukuran' => $ukuran],
            ['seragam' => 'olahraga', 'ukuran' => $ukuran],
            ['seragam' => 'almamater', 'ukuran' => $ukuran],
        ]);
    }
}
