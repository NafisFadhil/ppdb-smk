<?php

namespace App\Jobs;

use App\Helpers\ModelHelper;
use App\Models\DataJalurPendaftaran;
use App\Models\Identitas;
use App\Models\Jurusan;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class UpdatePeserta implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    protected $identitas;
    protected $identitas_creden;
    protected $seragam_creden;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Identitas $identitas, array $identitas_creden, array $seragam_creden)
    {
        $this->identitas = $identitas;
        $this->identitas_creden = $identitas_creden;
        $this->seragam_creden = $seragam_creden;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Import Variable
        $identitas = $this->identitas;
        $identitas_creden = $this->identitas_creden;
        $seragam_creden = $this->seragam_creden;
        $tagihan_creden = [];
        $verifikasi_creden = [];
        $jurusan_creden = [];

        // Alur Logika Jalur Pendaftaran
        $identitas_creden = Identitas::getSubPrestasi($identitas_creden);
        
        // Parse Nama Jurusan
        $jurusan = Jurusan::getJurusan($identitas_creden['nama_jurusan']);
        unset($identitas_creden['nama_jurusan']);
        
        // Checking State
        $pindah_jalur = (int) $identitas_creden['jalur_pendaftaran_id'] !== (int) $identitas->jalur_pendaftaran_id;
        $pindah_jurusan = strtolower($jurusan->singkatan) !== strtolower($identitas->jurusan->singkatan);

        // Get Jalur Pendaftaran
        $jalur = DataJalurPendaftaran::getJalurPendaftaran(
            $identitas_creden['jalur_pendaftaran_id']
        );

        // Handle Pindah Jalur
        if ($pindah_jalur || $pindah_jurusan) {
            // Tagihan Mocking
            $tagihan_creden = $this->resetTagihan($identitas, $jalur);

            // Verifikasi Mocking
            $verifikasi_creden = $this->resetVerifikasi();

            // Jurusan Mocking
            $jurusan_creden = [
                'nama' => $jurusan->nama,
                'slug' => $jurusan->slug,
                'singkatan' => $jurusan->singkatan,
            ];

            // Identitas Mocking
            $identitas_creden['status_id'] = 1;
        }
        // if (!isset($tagihan_creden['biaya_pendaftaran'])) throw new \Exception("Error Processing Request", 1);
        

        // cache(['tagihan_creden', $tagihan_creden], 1);
        // Cache::add('tagihan_creden', $tagihan_creden, now()->addSeconds(10));

        // dd($tagihan_creden);
        // Log::debug(dd($tagihan_creden));

        // Database Transaction
        Bus::chain([
            $identitas->jurusan->update($jurusan_creden),
            $identitas->tagihan->update($tagihan_creden),
            $identitas->verifikasi->update($verifikasi_creden),
            $identitas->seragam->update($seragam_creden),
            $identitas->update($identitas_creden),
        ])->dispatch();
        
    }

    protected function resetTagihan ($identitas, $jalur)
    {
        $tagihan_creden = [];
        $types = ['pendaftaran', 'daftar_ulang', 'seragam'];

        foreach ($types as $type) {
            $biaya = $jalur['biaya_'.$type];

            // ATTENTION !!! DANGER LINE CODE !!! ATTENTION !!! DANGER LINE CODE
            if ($type === 'pendaftaran') $biaya += 50000; // <== <== Danger Line Code Here
            // ATTENTION !!! DANGER LINE CODE !!! ATTENTION !!! DANGER LINE CODE
            
            $bayar = ModelHelper::getBayar($identitas->tagihan->pembayarans, $type);
            $kurang = $biaya - $bayar;
            $lunas = $kurang <= 0;

            // $tagihan_creden[] = [
            $tagihan_creden['biaya_'.$type] = $biaya;
            $tagihan_creden['tagihan_'.$type] = $kurang;
            $tagihan_creden['admin_'.$type.'_id'] = null;
            $tagihan_creden['lunas_'.$type] = $lunas;
            // ];
        }

        return $tagihan_creden;
    }

    protected function resetVerifikasi ()
    {
        // Verifikasi Loop Mocking
        $verifikasi_creden = [];
        $types = ['identitas', 'pendaftaran', 'daftar_ulang', 'seragam', 'sponsorship'];
        foreach ($types as $type) {
            // $verifikasi_creden[] = [
                $verifikasi_creden[$type] = false;
                $verifikasi_creden['tanggal_'.$type] = null;
                $verifikasi_creden['admin_'.$type.'_id'] = null;
            // ];
        }
        
        return $verifikasi_creden;
    }
    
}
