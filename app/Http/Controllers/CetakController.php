<?php

namespace App\Http\Controllers;

use App\Models\Identitas;
use Illuminate\Http\Request;

class CetakController extends Controller
{

    public function tgl_indo($tanggal){
        $bulan = array (
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $tanggal);
        
        // variabel pecahkan 0 = tanggal
        // variabel pecahkan 1 = bulan
        // variabel pecahkan 2 = tahun
     
        return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
    }

    public function cetakPendaftaran(Identitas $identitas){
        $identitas->tanggal_lahir = $this->tgl_indo($identitas->tanggal_lahir);
        return view('admin.pages.pdf-pendaftaran',['data' => $identitas]);
    }

    public function cetakFormulir(Identitas $identitas){
        $identitas->tanggal_lahir = $this->tgl_indo($identitas->tanggal_lahir);
        $identitas->date_now = $this->tgl_indo(date('Y-m-d'));
        return view('admin.pages.pdf-formulir',['data' => $identitas]);
    }
    
}
