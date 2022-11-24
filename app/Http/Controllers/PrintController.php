<?php

namespace App\Http\Controllers;

use App\Metadata\Formulir as MetadataFormulir;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    
    public function pendaftaran(Identitas $identitas)
    {
        return view('pages.hasil-print', [
            'siswa' => $identitas,
            'inputs' => MetadataFormulir::inputs()
        ]);
    }
    
}
