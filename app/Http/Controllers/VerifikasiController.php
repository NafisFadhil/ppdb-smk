<?php

namespace App\Http\Controllers;

use App\Models\Identitas;
use App\Models\Pendaftaran;
use App\Models\Jurusan;
use App\Models\User;
use App\Models\Dupayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
		return view('admin.pages.verifikasi.daftar-ulang', [
			'page' => ['title' => 'Verifikasi Daftar Ulang'],
			'peserta' => Identitas::whereRelation('status', 'level', 'Daftar Ulang')
                ->with(['pendaftaran', 'status'])->paginate(),
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
