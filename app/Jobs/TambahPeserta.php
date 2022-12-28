<?php

namespace App\Jobs;

use App\Models\DaftarUlang;
use App\Models\Identitas;
use App\Models\Jurusan;
use App\Models\Pendaftaran;
use App\Models\Seragam;
use App\Models\Tagihan;
use App\Models\Verifikasi;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Validator;

class TambahPeserta implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Collection $peserta;

    public array $creden;

    public int|null $id;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $creden, int|null $id = null)
    {
        $this->creden = $creden;
        $this->id = $id;
        if ($id !== null) {
            $this->creden['session_id'] = $id;
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $creden = $this->creden;
        $creden['sub_jalur_pendaftaran_id'] ??= 0;
        $creden = Identitas::getSubPrestasi($creden);

        if ($creden['nama_jurusan']) {
            $jurusan = Jurusan::getJurusan($creden['nama_jurusan']);
            unset($creden['nama_jurusan']);
        }

        $identitas = Identitas::create($creden);
        $tagihan = Tagihan::create([
            'biaya_pendaftaran' => $identitas->jalur_pendaftaran->biaya_pendaftaran,
            'tagihan_pendaftaran' => $identitas->jalur_pendaftaran->biaya_pendaftaran,
            'biaya_daftar_ulang' => $identitas->jalur_pendaftaran->biaya_daftar_ulang,
            'tagihan_daftar_ulang' => $identitas->jalur_pendaftaran->biaya_daftar_ulang,
            'biaya_seragam' => $identitas->jalur_pendaftaran->biaya_seragam,
            'tagihan_seragam' => $identitas->jalur_pendaftaran->biaya_seragam,
            'identitas_id' => $identitas->id,
        ]);
        $pendaftaran = Pendaftaran::create([
            'kode' => Pendaftaran::getKode(),
            'identitas_id' => $identitas->id
        ]);
        $jurusan = Jurusan::create([
            'nama' => $jurusan->nama,
            'slug' => $jurusan->slug,
            'singkatan' => $jurusan->singkatan,
            'identitas_id' => $identitas->id
        ]);
        $verifikasi = Verifikasi::create([
            'identitas_id' => $identitas->id
        ]);
        $seragam = Seragam::create([
            'identitas_id' => $identitas->id
        ]);

    }
}
