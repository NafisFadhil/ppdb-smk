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

    public function indexPendaftaran()
    {
        $laporan = $years = collect([]);
        
        if (request('type') && request('thn')) {
            $laporan = $this->filterPendaftaran();
        }

        $years = Pendaftaran::selectRaw('YEAR(updated_at) as year')->distinct()->get();

        return view('admin.pages.laporan.pendaftaran',[
            'page' => ['title' => 'Laporan Pendaftaran'],
            'thn' => $years,
            'type' => request('type'),
            'laporan' => $laporan
        ]);
    }

    // private function filterPendaftaran ()
    // {
    //     $type = request('type');
    //     $thn = request('thn');
    //     $year = $thn == 'all' ? '' : $thn;

    //     if ($type === 'pembayaran') {
    //         return DB::table('pendaftarans as p')
    //         ->join('identitas as i', 'p.identitas_id', '=', 'i.id')
    //         ->join('tagihans as t', 't.identitas_id', '=', 'i.id')
    //         ->where('p.updated_at', 'like', "$year%")
    //         ->whereNotNull('t.biaya_pendaftaran')
    //         ->select([
    //             'p.kode',
    //             't.biaya_pendaftaran',
    //             'p.updated_at',
    //             't.admin_pendaftaran as admin_biaya_pendaftaran',
    //             'i.nama_lengkap',
    //             'i.no_wa_siswa',
    //             'i.nama_jurusan'
    //         ])->get();
    //     } elseif ($type === 'pendaftaran') {
    //         return Identitas::where('created_at','like',"$year%")->get();
    //     }
    // }

}
