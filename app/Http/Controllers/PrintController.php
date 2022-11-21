<?php

namespace App\Http\Controllers;

use App\Metadata\Formulir as MetadataFormulir;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    
    public function pendaftaran(Pendaftaran $pendaftarans)
    {
        return view('pages.hasil-print', [
            'siswa' => $pendaftarans,
            'inputs' => MetadataFormulir::inputs()
        ]);
    }
    
}
