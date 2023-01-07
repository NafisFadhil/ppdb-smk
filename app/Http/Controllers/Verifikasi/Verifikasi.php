<?php

namespace App\Http\Controllers\Verifikasi;

use App\Http\Controllers\Controller;
use App\Models\Identitas;
use App\Strainer\Strain;
use Illuminate\Http\Request;

abstract class Verifikasi extends Controller
{

    protected Strain $strain;
    
    protected function getModel ($bigtype) {
        $model = Identitas::with([
            'jurusan', 'jalur_pendaftaran', 'jenis_kelamin',
            'tagihan', 'verifikasi', 'status', 'sponsorship'
        ]);
        
        if ($bigtype === 'pendaftaran') {
            return $model
            ->whereRelation('status', 'level', 'pendaftar');
        } elseif ($bigtype === 'duseragam') {
            return $model
            // ->whereRelation('verifikasi', 'pendaftaran', true)
            ->whereRelation('status', 'level', 'daftar ulang & seragam');
        } elseif ($bigtype === 'pendataan') {
            return $model
            ->whereRelation('verifikasi', 'pendaftaran', true)
            ->whereRelation('verifikasi', 'identitas', false);
        } elseif ($bigtype === 'sponsorship') {
            return $model->has('sponsorship')
                ->whereRelation('verifikasi', 'sponsorship', false);
        }
    }
    
}
