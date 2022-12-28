<?php

namespace Database\Seeders;

use App\Models\JalurPendaftaran;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;

class PesertaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $limit = 100;
        $jalurs = [1,2,3];
        $jalurs2 = [4,5,6,7,8];
        $jurusan = ['tkr', 'tsm', 'tkj', 'akuntansi', 'fkk'];

        for ($i = 1; $i <= $limit; $i++) {
            \App\Jobs\TambahPeserta::dispatch([
                'nama_jurusan' => $jurusan[rand(0,4)],
                'nama_lengkap' => $faker->name(),
                'tanggal_lahir' => $faker->date(),
                'asal_sekolah' => $faker->streetName(),
                'no_wa_siswa' => '08123456789',
                'jenis_kelamin_id' => rand(1,2),
                'jalur_pendaftaran_id' => rand(1,3),
                'sub_jalur_pendaftaran_id' => rand(4,8),
            ]);
        }

    }
}
