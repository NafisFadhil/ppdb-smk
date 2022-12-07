<?php

namespace App\Http\Controllers;

use App\Models\Identitas;
// use App\Models\Pendaftaran;
use App\Models\Jurusan;
use App\Models\User;
// use App\Models\Dupayment;
// use App\Models\DaftarUlang;
use App\Models\DUSeragam;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\DB;


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
            $duseragam = DUSeragam::create([
                'kode' => DUSeragam::getKode(),
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
    
    // Daftar Ulang & Seragam
    public function duSeragamIndex()
	{
        return view('admin.pages.verifikasi.duseragam', [
            'page' => ['title' => 'Verifikasi DU & Seragam'],
            'peserta' => Identitas::whereRelation('status', 'level', 'Daftar Ulang & Seragam')
                ->with(['pendaftaran', 'tagihan', 'status'])->paginate(),
        ]);
	}

    public function duSeragamBiaya(Request $req, Identitas $identitas)
    {
        $creden = $req->validate([
            'biaya_daftar_ulang' => 'required',
            'biaya_seragam' => 'required',
            'admin_duseragam' => 'required',
        ]);

        try {

            $identitas->tagihan->update([
                ...$creden,
                'tagihan_daftar_ulang' => $creden['biaya_daftar_ulang'],
                'tagihan_seragam' => $creden['biaya_seragam'],
                'admin_daftar_ulang' => $creden['admin_duseragam'],
                'admin_seragam' => $creden['admin_duseragam'],
            ]);

            $identitas->update(['status_id' => $identitas->status_id+1]);

            return redirect('/admin/verifikasi-duseragam')->withErrors([
                'alerts' => ['success' => 'Verifikasi biaya daftar ulang dan seragam berhasil.']
            ]);
            
        } catch (\Throwable $th) {

            return back()->withErrors([
                'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat memverifikasi biaya daftar ulang dan seragam.']
            ]);
            
        }
    }

	public function daftarUlangPembayaran(Request $req, Identitas $identitas)
	{
        $creden = $req->validate([
            'bayar' => 'required',
            'admin' => 'required',
        ]);
        
        try {
            
            $kurang = $identitas->tagihan->tagihan_daftar_ulang - $creden['bayar'];
            $calc = [
                'kurang' => $kurang < 0 ? 0 : $kurang,
                'lunas' => $kurang <= 0
            ];

            $pembayaran = Pembayaran::create([
                'type' => 'daftar_ulang',
                'kurang' => $calc['kurang'],
                'tagihan_id' => $identitas->tagihan->id,
                ...$creden,
            ]);
            $tagihan = $identitas->tagihan->update([
                'tagihan_daftar_ulang' => $calc['kurang'],
                'lunas_daftar_ulang' => $calc['lunas']
            ]);

            if ($calc['lunas'] && $identitas->tagihan->lunas_seragam) {
                $identitas->update(['status_id' => $identitas->status_id+1]);
            }

            return redirect('/admin/verifikasi-duseragam')->withErrors([
                'alerts' => ['success' => 'Input pembayaran daftar ulang siswa berhasil.']
            ]);
            
        } catch (\Throwable $th) {

            return back()->withErrors([
                'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat menginput pembayaran.']
            ]);
            
        }
	}

    public function seragamPembayaran(Request $req, Identitas $identitas)
    {
        $creden = $req->validate([
            'bayar' => 'required',
            'admin' => 'required',
        ]);
        
        try {
            
            $kurang = $identitas->tagihan->tagihan_seragam - $creden['bayar'];
            $calc = [
                'kurang' => $kurang < 0 ? 0 : $kurang,
                'lunas' => $kurang <= 0
            ];

            $pembayaran = Pembayaran::create([
                'type' => 'seragam',
                'kurang' => $calc['kurang'],
                'tagihan_id' => $identitas->tagihan->id,
                ...$creden,
            ]);
            $tagihan = $identitas->tagihan->update([
                'tagihan_seragam' => $calc['kurang'],
                'lunas_seragam' => $calc['lunas']
            ]);

            if ($calc['lunas'] && $identitas->tagihan->lunas_daftar_ulang) {
                $identitas->update(['status_id' => $identitas->status_id+1]);
            }

            return redirect('/admin/verifikasi-duseragam')->withErrors([
                'alerts' => ['success' => 'Input pembayaran seragam siswa berhasil.']
            ]);
            
        } catch (\Throwable $th) {
            return back()->withErrors([
                'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat menginput pembayaran.']
            ]);
            
        }
	}
    
	public function duSeragamVerifikasi(Request $req, Identitas $identitas)
	{
        $creden = $req->validate([
            'admin_verifikasi' => 'required',
        ]);

        try {
            
            $identitas->duseragam->update([
                'verifikasi' => true,
                ...$creden
            ]);
            $identitas->update([
                'status_id' => $identitas->status_id+1
            ]);
            
            return redirect('/admin/verifikasi-duseragam')->withErrors([
                'alerts' => ['success' => 'Siswa berhasil diverifikasi.']
            ]);
            
        } catch (\Throwable $th) {
            return back()->withErrors([
                'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat memverifikasi data.']
            ]);
        }
	}
    
}
