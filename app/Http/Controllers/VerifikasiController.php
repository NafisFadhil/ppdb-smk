<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Jurusan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class VerifikasiController extends Controller
{

    // Pendaftaran
    public function pendaftaranIndex()
    {
        return view('admin.pages.verifikasi.pendaftaran', [
            'page' => ['title' => 'Verifikasi Pendaftaran'],
            'peserta' => Pendaftaran::where('level_id', 1)->with(['pembayaran', 'identitas'])->paginate()
        ]);
    }

    public function pendaftaranPembayaran (Request $req, Pendaftaran $pendaftarans)
    {
        $creden = $req->validate([
            'jalur_pendaftaran' => 'required',
            'biaya_pendaftaran' => 'required',
            'ket_pendaftaran' => 'nullable',
            'nama_admin' => 'required',
        ]);

        try {

            $pendaftarans->pembayaran->update([
                'biaya_pendaftaran' => $creden['biaya_pendaftaran'],
                'ket_pendaftaran' => $creden['ket_pendaftaran'],
                'admin_pendaftaran' => $creden['nama_admin'],
            ]);

            return redirect('/admin/verifikasi/pendaftaran')->withErrors([
                'alerts' => ['success' => [
                    'msg' => 'Input pembayaran berhasil.',
                ]]
            ]);
            
        } catch (\Throwable $th) {

            return back()->withErrors([
                'alerts' => ['danger' => [
                    'msg' => 'Maaf, terjadi kesalahan saat menginput pembayaran.',
                ]]
            ]);
            
        }
    }
    
    public function pendaftaranVerifikasi(Request $req, Pendaftaran $pendaftarans)
    {
        $creden = $req->validate([
            'kode' => 'required',
            'nama_lengkap' => 'required',
            'nama_jurusan' => 'required',
            'jalur_pendaftaran' => 'required',
            'biaya_pendaftaran' => 'required',
            'nama_admin' => 'required',
        ]);

        try {
            $jurusan = Jurusan::create([
                'kode' => Jurusan::getKode($creden['nama_jurusan']),
                'nomor' => Jurusan::$nomor,
                'jurusan' => $creden['nama_jurusan']
            ]);

            $user = User::create([
                'name' => $pendaftarans->identitas->nama_lengkap,
                'username' => $jurusan->kode,
                'password' => Hash::make($pendaftarans->identitas->tanggal_lahir)
            ]);
    
            $pendaftarans->update([
                'nama_admin_pendaftaran' => $creden['nama_admin'],
                'jurusan_id' => $jurusan->id,
                'level_id' => $pendaftarans->level_id+1,
                'user_id' => $user->id,
            ]);
            
            return redirect('/admin/verifikasi/pendaftaran')->withErrors([
                'alerts' => ['success' => [
                    'msg' => 'Pendaftaran berhasil diverifikasi.',
                ]]
            ]);
            
        } catch (\Throwable $th) {
            return back()->withErrors([
                'alerts' => ['danger' => [
                    'msg' => 'Maaf, terjadi kesalahan saat memverifikasi data.',
                ]]
            ]);
        }
    }
    
    // Daftar Ulang
    public function daftarUlangIndex()
	{
		return view('admin.pages.verifikasi.daftar-ulang', [
			'page' => ['title' => 'Verifikasi Daftar Ulang'],
			'peserta' => Pendaftaran::where('level_id', 2)->with(['pembayaran', 'identitas'])->paginate()
		]);
	}

	public function daftarUlangPembayaran()
	{
	}
    
	public function daftarUlangVerifikasi()
	{
	}
    
}
