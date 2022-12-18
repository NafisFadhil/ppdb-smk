<?php

namespace App\Http\Controllers\Verifikasi;

use App\Http\Controllers\Controller;
use App\Models\Identitas;
use Illuminate\Http\Request;

class PendataanController extends Controller
{
	
	public function index()
	{
		session(['oldpath' => request()->path()]);
		return view('admin.pages.verifikasi.pendataan', [
			'page' => ['title' => 'Verifikasi Pendataan'],
			'peserta' => Identitas::where('status_id', '>', 3)
				->with(['jalur_pendaftaran'])->get()
		]);
	}

	public function verifikasi(Request $req, Identitas $identitas)
	{
		$creden = $req->validate([
            'admin_verifikasi' => 'required|string'
        ]);

        try {

            $identitas->update([
                ...$creden,
                'verifikasi' => true,
                'tanggal_verifikasi' => now(),
                'status_id' => 7
            ]);

            return redirect('/admin/verifikasi/pendataan')->withErrors([
                'alerts' => ['success' => 'Data identitas berhasil diverifikasi.']
            ]);
            
        } catch (\Throwable $th) {
            throw $th;
            return back()->withErrors([
                'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat memverifikasi data.']
            ])->withInput($creden);
        }
	}
	
}
