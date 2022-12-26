<?php

namespace App\Jobs;

use App\Models\Identitas;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ResetVerifikasi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Identitas $identitas;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Identitas $identitas)
    {
        $this->identitas = $identitas;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $verifikasi_creden = [];
        $types = ['identitas', 'pendaftaran', 'daftar_ulang', 'seragam', 'sponsorship'];
        foreach ($types as $type) {
            $verifikasi_creden[$type] = false;
            $verifikasi_creden['tanggal_'.$type] = null;
            $verifikasi_creden['admin_'.$type.'_id'] = null;
        }
        
        return $this->identitas->verifikasi->update($verifikasi_creden);
    }
}
