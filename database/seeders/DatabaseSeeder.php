<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

        \App\Models\Identitas::create([
            'jalur_pendaftaran' => 'Prestasi',
            'nama_lengkap' => 'Slamet Kopling',
            'tanggal_lahir' => now(),
            'jenis_kelamin' => 'Laki-laki',
            'no_wa_ortu' => '085123456789',
            'no_wa_siswa' => '085123456789',
            'asal_sekolah' => 'MTS Hindu Bogor',
            'nama_jurusan' => 'tbsm',
        ]);
        \App\Models\Pendaftaran::create([
            'kode' => 'P-001',
            'identitas_id' => 1,
        ]);

        $this->call([
            ConfigSeeder::class,
            UserLevelSeeder::class,
            UserSeeder::class,
            StatusSeeder::class,
        ]);
    }
}
