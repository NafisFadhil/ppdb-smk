<?php

namespace App\Http\Controllers;

use App\Models\Identitas;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

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
        // dd($bulan[3]);
        
        // variabel pecahkan 2 = tanggal
        // variabel pecahkan 1 = bulan
        // variabel pecahkan 0 = tahun
     
        return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
    }

    public function cetakPendaftaran(Identitas $identitas){
        $identitas->new_tanggal_lahir = $this->tgl_indo(date('Y-n-d', $identitas->tanggal_lahir));
        return view('admin.pages.pdf-pendaftaran',['data' => $identitas]);
    }

    public function cetakFormulir(Identitas $identitas){
        $identitas->new_tanggal_lahir = $this->tgl_indo(date('Y-n-d', $identitas->tanggal_lahir));
        $identitas->date_now = $this->tgl_indo(date('Y-n-d'));
        return view('admin.pages.pdf-formulir',['data' => $identitas]);
    }
    
}
