<?php

namespace App\Http\Controllers\Verifikasi;

use App\Http\Controllers\Controller;
use App\Models\Identitas;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class DuseragamController extends Controller
{
    public function index()
	{
        session(['oldpath' => request()->path()]);
        return view('admin.pages.verifikasi.duseragam', [
            'page' => ['title' => 'Verifikasi DU & Seragam'],
            'peserta' => Identitas::whereRelation('status', 'level', 'Daftar Ulang & Seragam')
                ->with(['pendaftaran', 'tagihan', 'status'])->paginate(),
        ]);
	}

    public function biaya(Request $req, Identitas $identitas)
    {
        $creden = $req->validate([
            'biaya_daftar_ulang' => 'required',
            'biaya_seragam' => 'required',
            'admin_duseragam' => 'required',
        ]);
        $duscreden = $req->validate([
            'keterangan' => 'nullable',
        ]);

        try {

            $bayars = [
                'daftar_ulang' => Pembayaran::getBayar($identitas->tagihan->pembayarans, 'daftar_ulang'),
                'seragam' => Pembayaran::getBayar($identitas->tagihan->pembayarans, 'seragam'),
            ];
            
            $tagihans = [
                'daftar_ulang' => $creden['biaya_daftar_ulang'] - $bayars['daftar_ulang'],
                'seragam' => $creden['biaya_seragam'] - $bayars['seragam'],
            ]; foreach ($tagihans as $type => $value) $tagihans[$type] = $value <= 0 ? 0 : $value;

            $identitas->tagihan->update([
                ...\Illuminate\Support\Arr::except($creden, 'admin_duseragam'),
                'tagihan_daftar_ulang' => $tagihans['daftar_ulang'],
                'lunas_daftar_ulang' => $tagihans['daftar_ulang']<=0,
                'tagihan_seragam' => $tagihans['seragam'],
                'lunas_seragam' => $tagihans['seragam']<=0,
                'admin_daftar_ulang' => $creden['admin_duseragam'],
                'admin_seragam' => $creden['admin_duseragam'],
            ]);
            $identitas->duseragam->update($duscreden);

            if ($identitas->reset) {
                $identitas->update([
                    'status_id' => $tagihans['daftar_ulang']<=0&&$tagihans['seragam']<=0 ? 6 : $identitas->status_id+1,
                    'reset' => false,
                    'old_status_id' => 0
                ]);
                $alerts['warning'] = 'Perubahan jalur pendaftaran berhasil diselesaikan. Status siswa disesuaikan dengan status lama.';
            } else $identitas->update(['status_id' => $tagihans['daftar_ulang']<=0&&$tagihans['seragam']<=0 ? 6 : $identitas->status_id+1]);

            return redirect('/admin/verifikasi/duseragam')->withErrors([
                'alerts' => ['success' => 'Verifikasi biaya daftar ulang dan seragam berhasil.']
            ]);
            
        } catch (\Throwable $th) {
            throw $th;
            return back()->withErrors([
                'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat memverifikasi biaya daftar ulang dan seragam.']
            ]);
            
        }
    }

	public function pembayaran(Request $req, $type, Identitas $identitas)
	{
        $type = str_replace('-', '_', $type);
        $xtype = str_replace('_', ' ', $type);
        $invtype = $type === 'seragam' ? 'daftar_ulang' : $xtype;
        $creden = $req->validate([
            'bayar' => 'required',
            'admin' => 'required',
        ]);
        
        try {
            
            $kurang = $identitas->tagihan["tagihan_$type"] - $creden['bayar'];
            $calc = [
                'kurang' => $kurang <= 0 ? 0 : $kurang,
                'lunas' => $kurang <= 0
            ];

            $pembayaran = Pembayaran::create([
                'type' => $type,
                'kurang' => $calc['kurang'],
                'tagihan_id' => $identitas->tagihan->id,
                ...$creden,
            ]);
            $tagihan = $identitas->tagihan->update([
                "tagihan_$type" => $calc['kurang'],
                "lunas_$type" => $calc['lunas']
            ]);

            if ($calc['lunas'] && $identitas->tagihan["lunas_$invtype"]) {
                $identitas->update(['status_id' => $identitas->status_id+1]);
            }

            return redirect('/admin/verifikasi/duseragam')->withErrors([
                'alerts' => ['success' => "Input pembayaran $xtype berhasil."]
            ]);
            
        } catch (\Throwable $th) {
            throw $th;
            return back()->withErrors([
                'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat menginput pembayaran.']
            ]);
            
        }
	}
    
	public function verifikasi(Request $req, Identitas $identitas)
	{
        $creden = $req->validate([
            'admin_verifikasi' => 'required',
        ]);

        try {
            
            $identitas->duseragam->update([
                ...$creden,
                'verifikasi' => true,
            ]);
            $identitas->update([ 'status_id' => $identitas->status_id+1 ]);
            
            return redirect('/admin/verifikasi/duseragam')->withErrors([
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
