<?php

namespace App\Http\Controllers\Verifikasi;

use App\Filters\Filter;
use App\Filters\FilterOptions;
use App\Http\Controllers\Controller;
use App\Models\DataJalurPendaftaran;
use App\Models\Identitas;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class PendataanController extends Controller
{
	
    private function getModel() {
        return Identitas::with([
            'daftar_ulang', 'status', 'jenis_kelamin', 'jurusan', 'tagihan', 'verifikasi'
        ])
        ->whereRelation('verifikasi', 'pendaftaran', true)
        ->whereRelation('verifikasi', 'identitas', false);
    }
    
	public function index(Request $req)
	{
		session(['oldpath' => request()->path()]);
        $data = Filter::filter($this->getModel(), $req, 'verifikasi', 'pendataan', relation: '-');
        
        return view('admin.pages.table', [
            'page' => ['title' => 'Verifikasi Pendataan'],
            'table' => 'verifikasi-pendataan',
            'peserta' => $data,
            'filters' => FilterOptions::getVerifikasiFormOptions('pendataan')
        ]);
	}

	public function verifikasi(Request $req, Identitas $identitas)
	{
        // Initiation Credentials
        $verifikasi_creden = [];
        $identitas_creden = [];
        $alerts = [];

        try {

            // Mock Verifikasi
            $verifikasi_creden = [
                'identitas' => true,
                'tanggal_identitas' => now(),
                'admin_identitas_id' => $req->user()->id
            ];

            // Mock Identitas
            $addlevel = strtolower($identitas->status->level) === 'pendataan' ? 1 : 0;
            $identitas_creden['status_id'] = $identitas->status_id + $addlevel;

            dispatch_sync(function () use (
                $identitas, $verifikasi_creden, $identitas_creden
            ) {
                $identitas->verifikasi->update($verifikasi_creden);
                $identitas->update($identitas_creden);
            });

            $alerts['success'] = 'Berhasil memverifikasi siswa.';

            return back()->withErrors([
                'alerts' => ['success' => 'Data identitas berhasil diverifikasi.']
            ]);
            
        } catch (\Throwable $th) {
            throw $th;
            return back()->withErrors([
                'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat memverifikasi data.']
            ])->withInput($req->toArray());
        }
	}
	
}
