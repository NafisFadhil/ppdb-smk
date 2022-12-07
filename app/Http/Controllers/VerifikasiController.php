<?php

namespace App\Http\Controllers;

use App\Models\Identitas;
use App\Models\Pendaftaran;
use App\Models\Jurusan;
use App\Models\User;
use App\Models\Dupayment;
use App\Models\DaftarUlang;
use App\Models\Pembayaran;
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
            'admin_pendaftaran' => 'required',
        ]);
        try {

            $identitas->tagihan->update([
                ...$creden,
                'tagihan_pendaftaran' => $creden['biaya_pendaftaran']
            ]);

            $identitas->update(['status_id' => $identitas->status_id+1]);

            return redirect('/admin/verifikasi-pendaftaran')->withErrors([
                'alerts' => ['success' => 'Verifikasi biaya pendaftaran berhasil.']
            ]);
            
        } catch (\Throwable $th) {

            return back()->withErrors([
                'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat memverifikasi biaya pendaftaran.']
            ]);
            
        }
    }

    public function pendaftaranPembayaran (Request $req, Identitas $identitas)
    {
        $creden = $req->validate([
            'bayar' => 'required',
            'admin' => 'required',
        ]);
        
        try {
            
            $kurang = $identitas->tagihan->tagihan_pendaftaran - $creden['bayar'];
            $calc = [
                'kurang' => $kurang < 0 ? 0 : $kurang,
                'lunas' => $kurang <= 0
            ];

            $pembayaran = Pembayaran::create([
                'type' => 'pendaftaran',
                'kurang' => $calc['kurang'],
                'tagihan_id' => $identitas->tagihan->id,
                ...$creden,
            ]);
            $tagihan = $identitas->tagihan->update([
                'tagihan_pendaftaran' => $calc['kurang'],
                'lunas_pendaftaran' => $calc['lunas']
            ]);

            if ($calc['lunas']) $identitas->update(['status_id' => $identitas->status_id+1]);

            return redirect('/admin/verifikasi-pendaftaran')->withErrors([
                'alerts' => ['success' => 'Input pembayaran siswa berhasil.']
            ]);
            
        } catch (\Throwable $th) {
            throw $th;

            return back()->withErrors([
                'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat menginput pembayaran.']
            ]);
            
        }
    }
    
    public function pendaftaranVerifikasi(Request $req, Identitas $identitas)
    {
        $creden = $req->validate([
            'admin_verifikasi' => 'required',
        ]);

        try {
            
            $jurusan = Jurusan::create([
                'identitas_id' => $identitas->id,
                ...Jurusan::new($identitas->nama_jurusan),
            ]);
            $user = User::create([
                'name' => $identitas->nama_lengkap,
                'username' => $jurusan->kode,
                'password' => Hash::make($identitas->tanggal_lahir),
                'identitas_id' => $identitas->id
            ]);
            $identitas->pendaftaran->update([
                'verifikasi' => true,
                ...$creden
            ]);
            $du = DaftarUlang::create([
                'identitas_id' => $identitas->id,
            ]);
            $identitas->update([
                'status_id' => $identitas->status_id+1
            ]);
            
            return redirect('/admin/verifikasi-pendaftaran')->withErrors([
                'alerts' => ['success' => 'Siswa berhasil diverifikasi.']
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
                DB::raw('(CASE 
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
