<?php

namespace App\Jobs;

use App\Helpers\ModelHelper;
use App\Models\Identitas;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ResetTagihan implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Identitas $identitas;

    protected $jalur;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Identitas $identitas, $jalur)
    {
        $this->identitas = $identitas;
        $this->jalur = $jalur;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $tagihan_creden = [];
        $types = ['pendaftaran', 'daftar_ulang', 'seragam'];

        foreach ($types as $type) {
            $biaya = $this->jalur['biaya_'.$type];

            // ATTENTION !!! DANGER LINE CODE !!! ATTENTION !!! DANGER LINE CODE
            if ($type === 'pendaftaran') $biaya += 50000; // <== <== Danger Line Code Here
            // ATTENTION !!! DANGER LINE CODE !!! ATTENTION !!! DANGER LINE CODE
            
            $bayar = ModelHelper::getBayar($this->identitas->tagihan->pembayarans, $type);
            $kurang = $biaya - $bayar;
            $lunas = $kurang <= 0;

            $tagihan_creden['biaya_'.$type] = $biaya;
            $tagihan_creden['tagihan_'.$type] = $kurang;
            $tagihan_creden['admin_'.$type.'_id'] = null;
            $tagihan_creden['lunas_'.$type] = $lunas;
        }

        $this->identitas->tagihan()->update($tagihan_creden);
    }
}
