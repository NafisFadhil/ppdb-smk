<?php

namespace App\Http\Controllers;

use App\Models\Identitas;
use App\Models\Pendaftaran;
use App\Models\Jurusan;
use App\Models\User;
use App\Models\Dupayment;
use App\Models\DaftarUlang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class VerifikasiController extends Controller
{

    // Pendaftaran
    public function pendaftaranIndex()
    {
        
        return view('admin.pages.verifikasi.pendaftaran', [
            'page' => ['title' => 'Verifikasi Pendaftaran'],
            'peserta' => Identitas::whereRelation('status', 'level', 'Pendaftar')
                ->with(['pendaftaran', 'status'])->paginate(),
        ]);
    }

    public function pendaftaranBiaya (Request $req, Identitas $identitas)
    {
        $creden = $req->validate([
            'biaya_pendaftaran' => 'required',
            'admin_biaya_pendaftaran' => 'required',
        ]);
        try {

            $identitas->pendaftaran->update($creden);
            $identitas->update(['status_id' => 2]);

            return redirect('/admin/verifikasi-pendaftaran')->withErrors([
                'alerts' => ['success' => 'Input pembayaran berhasil.']
            ]);
            
        } catch (\Throwable $th) {

            return back()->withErrors([
                'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat menginput pembayaran.']
            ]);
            
        }
    }

    public function pendaftaranPembayaran (Request $req, Identitas $identitas)
    {
        $creden = $req->validate([
            'pembayaran_siswa' => 'required',
            'admin_pembayaran_siswa' => 'required',
            'lunas' => 'required',
        ]);

        try {

            $identitas->pendaftaran->update($creden);
            $identitas->update(['status_id' => 3]);

            return redirect('/admin/verifikasi-pendaftaran')->withErrors([
                'alerts' => ['success' => 'Input pembayaran siswa berhasil.']
            ]);
            
        } catch (\Throwable $th) {

            return back()->withErrors([
                'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat menginput pembayaran.']
            ]);
            
        }
    }
    
    public function pendaftaranVerifikasi(Request $req, Identitas $identitas)
    {
        $creden = $req->validate([
            'admin_verifikasi_pendaftaran' => 'required',
        ]);
        try {
            
            $jur = Jurusan::new($identitas->nama_jurusan);
            $jur['identitas_id'] = $identitas->id;
            $jurusan = Jurusan::create($jur);
            $user = User::create([
                'name' => $identitas->nama_lengkap,
                'username' => $jurusan->kode,
                'password' => Hash::make($identitas->tanggal_lahir),
                'identitas_id' => $identitas->id
            ]);
            $creden['verifikasi_pendaftaran'] = true;
            $identitas->pendaftaran->update($creden);
            DaftarUlang::create([
                'identitas_id' => $identitas->id,
                'pembayaran' => 0,
                'angsuran' => 0,
                'lunas' => 0,
            ]);
            $identitas->update([
                'status_id' => 4
            ]);
            
            return redirect('/admin/verifikasi-pendaftaran')->withErrors([
                'alerts' => ['success' => 'Data berhasil diverifikasi.']
            ]);
            
        } catch (\Throwable $th) {
            return back()->withErrors([
                'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat memverifikasi data.']
            ]);
        }
    }
    
    // Daftar Ulang
    public function daftarUlangIndex()
	{
        $du = DB::table('identitas as i')
                ->join('pendaftarans as p', 'p.identitas_id', '=', 'i.id') 
                ->where('p.verifikasi_pendaftaran','=','1')
                ->join('jurusans as j','j.identitas_id','=','i.id')
                ->join('dupayments as dp', 'dp.jalur_pendaftaran','=','i.jalur_pendaftaran')
                ->join('daftar_ulangs as du', 'du.identitas_id','=','i.id')
                ->select('j.kode','i.nama_lengkap','i.jalur_pendaftaran',
                'i.jenis_kelamin','i.asal_sekolah','i.nama_jurusan','i.id', 'du.angsuran','du.pembayaran',
                \DB::raw('(CASE 
                        WHEN du.pembayaran = dp.payment THEN "lunas" 
                        ELSE CONCAT("Pembayaran kurang Rp ",FORMAT(dp.payment-du.pembayaran, 2, "id_ID") ) 
                        END) AS status'))
                ->paginate();
		return view('admin.pages.verifikasi.daftar-ulang', [
			'page' => ['title' => 'Verifikasi Daftar Ulang'],
			'peserta' => $du,
            'payment' => Dupayment::all()
		]);
	}

    public function duPayment(Request $req){
        $req->validate([
            'Umum' => 'required', 
            'Prestasi' => 'required', 
            'Bidikmisi' => 'required', 
        ]);
        try{
            $data = $req->all();
            foreach($data as $k => $r):
                $k != "_token" && Dupayment::where('jalur_pendaftaran',$k)->update(['payment' => $r]);
            endforeach;
            return redirect('/admin/verifikasi-daftar-ulang')->withErrors([
                'alerts' => ['success' => 'Data berhasil di update']
            ]);
        }catch (\Throwable $th) {
            return back()->withErrors([
                'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat edit data.']
            ]);
        }
    }

	public function daftarUlangPembayaran()
	{
	}
    
	public function daftarUlangVerifikasi()
	{
	}
    
}
