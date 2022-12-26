<?php

namespace Database\Seeders;

use App\Models\DataJenisKelamin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataJenisKelaminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('data_jenis_kelamins')->insert([
            [
                'name' => 'laki-laki',
                'label' => 'LAKI-LAKI'
            ],
            [
                'name' => 'perempuan',
                'label' => 'PEREMPUAN'
            ],
        ]);
    }
}
