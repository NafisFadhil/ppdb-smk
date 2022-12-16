<?php

namespace App\Http\Controllers\Verifikasi;

use App\Http\Controllers\Controller;
use App\Models\Identitas;
use App\Models\Pendaftaran;
use App\Models\Sponsorship;
use Illuminate\Http\Request;

class SponsorshipController extends Controller
{

    protected $validations = [
        'nama' => 'required|string',
        'kelas' => 'required|string',
        'no_wa' => 'required|numeric',
        'identitas_id' => 'required|numeric'
    ];
    
    public function index()
    {
        return view('admin.pages.sponsorship', [
            'page' => ['title' => 'Data Sponsorship'],
            'sponsorship' => Sponsorship::latest()->with(['identitas'])->paginate(),
            'peserta' => Identitas::select(['id', 'nama_lengkap', 'asal_sekolah'])->get()
        ]);
    }

    public function store(Request $req)
    {
        $creden = $req->validate($this->validations);
        try {
            
            $sponsorship = Sponsorship::create($creden);

            return redirect('/admin/verifikasi/sponsorship')->withErrors([
                'alerts' => ['success' => 'Sponsorship berhasil ditambahkan.']
            ]);
            
        } catch (\Throwable $th) {
            throw $th;
            return back()->withErrors([
                'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat menambahkan sponsorship.']
            ])->withInput($creden);
        }
    }

    public function update(Request $req, Sponsorship $sponsorship)
    {
        $creden = $req->validate($this->validations);

        try {

            $sponsorship->update($creden);

            return redirect('/admin/verifikasi/sponsorship')->withErrors([
                'alerts' => ['success' => 'Data sponsorship berhasil diubah.']
            ]);
            
        } catch (\Throwable $th) {
            throw $th;
            return back()->withErrors([
                'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat mengubah data.']
            ])->withInput($creden);
        }
    }

    public function verifikasi (Request $req, Sponsorship $sponsorship)
    {
        $creden = $req->validate([
            'admin_verifikasi' => 'required|string'
        ]);

        try {

            $sponsorship->update([
                ...$creden,
                'verifikasi' => true,
                'tanggal_verifikasi' => now()
            ]);

            return redirect('/admin/verifikasi/sponsorship')->withErrors([
                'alerts' => ['success' => 'Data sponsorship berhasil diverifikasi.']
            ]);
            
        } catch (\Throwable $th) {
            throw $th;
            return back()->withErrors([
                'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat memverifikasi data.']
            ])->withInput($creden);
        }
    }
    
}
