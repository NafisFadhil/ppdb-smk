<?php

namespace Database\Seeders;

use App\Models\JalurPendaftaran;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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
        $seeds = [
            'identitas' => [],
            'tagihan' => [],
            'duseragam' => [],
            'pendaftaran' => [],
        ];
        $jenisKelamin = ['LAKI-LAKI', 'PEREMPUAN'];
        $jurusan = ['TKR', 'TSM', 'TKJ', 'AKUNTANSI', 'FKK'];
        $count = [
            'duseragam' => 0,
            'pendaftaran' => 0,
        ];
        $now = now();

        for ($i = 1; $i <= $limit; $i++) {
            $seeds['identitas'][] = [
                'id' => $i,
                'jalur_pendaftaran_id' => rand(1,8),
                'nama_lengkap' => $faker->name(),
                'tanggal_lahir' => $faker->date(),
                'jenis_kelamin' => $jenisKelamin[rand(0,1)],
                'asal_sekolah' => $faker->streetName(),
                'no_wa_siswa' => $faker->phoneNumber(),
                'nama_jurusan' => $jurusan[rand(0,4)],
                'created_at' => $now,
                'updated_at' => $now,
            ];
            $seeds['tagihan'][] = [
                'identitas_id' => $i,
                'created_at' => $now,
                'updated_at' => $now,
            ];
            $seeds['duseragam'][] = [
                'kode' => 'DU-'.str_pad($count['duseragam']++, 3, '0', STR_PAD_LEFT),
                'identitas_id' => $i,
                'created_at' => $now,
                'updated_at' => $now,
            ];
            $seeds['pendaftaran'][] = [
                'kode' => 'P-'.str_pad($count['pendaftaran']++, 3, '0', STR_PAD_LEFT),
                'identitas_id' => $i,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('identitas')->insertOrIgnore($seeds['identitas']);
        DB::table('tagihans')->insertOrIgnore($seeds['tagihan']);
        DB::table('duseragams')->insertOrIgnore($seeds['duseragam']);
        DB::table('pendaftarans')->insertOrIgnore($seeds['pendaftaran']);
        
    }
}
