<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\Identitas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



class LaporanController extends Controller
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

    public function indexPendaftaran(){

        return view('admin.pages.laporan.pendaftaran',[
                'page' => ['title' => 'Laporan Pendaftaran'],
                'thn' => Pendaftaran::selectRaw('YEAR(updated_at) as year')->distinct()->get()
            ]
        );
    }

    public function filterPendaftaran(Request $req){
        $req->validate([
            'thn' => 'required',
            'laporan' => 'required',
        ]);
        $year = $req->thn == 'all' ? '' : $req->thn;
        $laporan = $req->laporan == 'pembayaran' ? DB::table('pendaftarans as p')
            ->whereYear('p.updated_at', 'like', '%'.$year)
            ->where('p.biaya_pendaftaran', '!=', NULL)
            ->join('identitas as i', 'p.identitas_id', '=', 'i.id')
            ->select('p.kode', 'p.biaya_pendaftaran', 'p.updated_at','p.admin_biaya_pendaftaran', 
            'i.nama_lengkap', 'i.no_wa_siswa','i.nama_jurusan')
            ->get()
            :
            Identitas::whereYear('created_at','like','%'.$year)->get();
        return back()->with([
            'laporan' => $laporan,
            'type' => $req->laporan
        ]);
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
