<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



class LaporanController extends Controller
{
    function indexPendaftaran(){

        return view('admin.pages.laporan.pendaftaran',[
                'page' => ['title' => 'Laporan Pendaftaran'],
                'thn' => Pendaftaran::selectRaw('YEAR(updated_at) as year')->distinct()->get()
            ]
        );
    }

    function filterPendaftaran(Request $req){
        $req->validate([
            'thn' => 'required',
            'laporan' => 'required',
        ]);
        $year = $req->thn == 'all' ? '' : $req->thn;
        $laporan = DB::table('pendaftarans as p')
            ->whereYear('p.updated_at', 'like', '%'.$year)
            ->where('p.biaya_pendaftaran', '!=', NULL)
            ->join('identitas as i', 'p.identitas_id', '=', 'i.id')
            ->select('p.kode', 'p.biaya_pendaftaran', 'p.updated_at','p.admin_biaya_pendaftaran', 
            'i.nama_lengkap', 'i.no_wa_siswa','i.nama_jurusan')
            ->get();
        return back()->with([
            'laporan' => $laporan,
        ]);
    }
}
