<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\DUSeragam;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        
        $this->call([
            ConfigSeeder::class,
            UserLevelSeeder::class,
            UserSeeder::class,
            StatusSeeder::class,
            DataJurusanSeeder::class,
            JalurPendaftaranSeeder::class,
            // PesertaSeeder::class,
        ]);
        
        // $identitas = \App\Models\Identitas::create([
        //     'nama_lengkap' => 'Slamet Kopling',
        //     'tanggal_lahir' => now(),
        //     'jenis_kelamin' => 'Laki-laki',
        //     'no_wa_ortu' => '085123456789',
        //     'no_wa_siswa' => '085123456789',
        //     'asal_sekolah' => 'MTS Hindu Bogor',
        //     'nama_jurusan' => 'tsm',
        //     'jalur_pendaftaran_id' => 2,
        // ]);
        // $duseragam = DUSeragam::create([
        //     'kode' => DUSeragam::getKode(),
        //     'identitas_id' => $identitas->id,
        // ]);
        // $tagihan = \App\Models\Tagihan::create([
        //     'biaya_pendaftaran' => $identitas->jalur_pendaftaran->biaya_pendaftaran,
        //     'tagihan_pendaftaran' => $identitas->jalur_pendaftaran->biaya_pendaftaran,
        //     'biaya_daftar_ulang' => $identitas->jalur_pendaftaran->biaya_daftar_ulang,
        //     'tagihan_daftar_ulang' => $identitas->jalur_pendaftaran->biaya_daftar_ulang,
        //     'biaya_seragam' => $identitas->jalur_pendaftaran->biaya_seragam,
        //     'tagihan_seragam' => $identitas->jalur_pendaftaran->biaya_seragam,
        //     'identitas_id' => $identitas->id,
        // ]);
        // \App\Models\Pendaftaran::create([
        //     'kode' => 'P-001',
        //     'identitas_id' => $identitas->id,
        // ]);
    }
}
