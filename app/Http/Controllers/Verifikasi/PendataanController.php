<?php

namespace App\Http\Controllers\Verifikasi;

use App\Filters\Filter;
use App\Filters\FilterOptions;
use App\Http\Controllers\Controller;
use App\Models\DataJalurPendaftaran;
use App\Models\Identitas;
use App\Models\Jurusan;
use App\Strainer\Strain;
use Illuminate\Http\Request;

class PendataanController extends Verifikasi
{
	
	public function index(Request $req)
	{
		session(['oldpath' => request()->path()]);
        
        $strain = $this->strain = new Strain($this->getModel('pendataan'), $req, [
            'suptype' => 'verifikasi',
            'type' => 'pendataan',
            'with_subquery' => false
        ]);
        
        return view('admin.pages.tverifikasi', [
            'page' => ['title' => 'Verifikasi Pendataan'],
            'table' => 'pendataan',
            'peserta' => $strain->query,
            'filters' => $strain->form_options
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

            $identitas->verifikasi->update($verifikasi_creden);
            $identitas->update($identitas_creden);

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
