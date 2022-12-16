<?php

namespace App\Http\Controllers\Verifikasi;

use App\Http\Controllers\Controller;
use App\Models\Identitas;
use App\Models\Jurusan;
use App\Models\Pembayaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PendaftaranController extends Controller
{
    public function index ()
    {
        return view('admin.pages.verifikasi.pendaftaran', [
            'page' => ['title' => 'Verifikasi Pendaftaran'],
            'peserta' => Identitas::whereRelation('status', 'level', 'Pendaftar')
                ->with(['pendaftaran', 'status'])->paginate(),
        ]);
    }

    public function biaya (Request $req, Identitas $identitas)
    {
        $creden = $req->validate([
            'biaya_pendaftaran' => 'required',
            'admin_pendaftaran' => 'required',
        ]);
        $duscreden = $req->validate([ 'keterangan' => 'nullable' ]);
        $alerts = [];
        
        try {

            $identitas->tagihan->update([
                ...$creden,
                'tagihan_pendaftaran' => $creden['biaya_pendaftaran']
            ]);
            $identitas->duseragam->update($duscreden);

            if ($identitas->reset) {
                $bayar = Pembayaran::getBayar($identitas->tagihan->pembayarans, 'pendaftaran');
                $lunas = $creden['biaya_pendaftaran'] - $bayar <= 0;
                if ($identitas->old_status_id >= 4 && $lunas) {
                    $identitas->update(['status_id' => 4]);
                } else {
                    $identitas->update([
                        'status_id' => $identitas->status_id+1,
                        'reset' => false,
                        'old_status_id' => 0
                    ]);
                    $alerts['success'] = 'Perubahan jalur pendaftaran berhasil diselesaikan. Status siswa disesuaikan dengan status lama.';
                }
            } else $identitas->update(['status_id' => $identitas->status_id+1]);

            return redirect('/admin/verifikasi/pendaftaran')->withErrors([
                'alerts' => [
                    'success' => 'Verifikasi biaya pendaftaran berhasil.',
                    ...$alerts
                ]
            ]);
            
        } catch (\Throwable $th) {
            throw $th;
            return back()->withErrors([
                'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat menginput biaya pendaftaran.']
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
                ...$creden,
                'type' => 'pendaftaran',
                'kurang' => $calc['kurang'],
                'tagihan_id' => $identitas->tagihan->id,
            ]);
            $tagihan = $identitas->tagihan->update([
                'tagihan_pendaftaran' => $calc['kurang'],
                'lunas_pendaftaran' => $calc['lunas']
            ]);

            if ($calc['lunas']) $identitas->update(['status_id' => $identitas->status_id+1]);

            return redirect('/admin/verifikasi/pendaftaran')->withErrors([
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
            $identitas->update([
                'status_id' => $identitas->status_id+1
            ]);
            
            return redirect('/admin/verifikasi/pendaftaran')->withErrors([
                'alerts' => ['success' => 'Siswa berhasil diverifikasi.']
            ]);
            
        } catch (\Throwable $th) {
            throw $th;
            return back()->withErrors([
                'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat memverifikasi data.']
            ]);
        }
    }
}
