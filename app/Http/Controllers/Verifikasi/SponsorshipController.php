<?php

namespace App\Http\Controllers\Verifikasi;

use App\Filters\Filter;
use App\Filters\FilterOptions;
use App\Http\Controllers\Controller;
use App\Models\DataJalurPendaftaran;
use App\Models\Identitas;
use App\Models\Jurusan;
use App\Models\Pendaftaran;
use App\Models\Sponsorship;
use App\Strainer\Strain;
use App\Validations\SponsorshipValidation;
use Illuminate\Http\Request;

class SponsorshipController extends Verifikasi
{

    public function index(Request $req)
    {
        session(['oldpath' => request()->path()]);
        
        $strain = $this->strain = new Strain($this->getModel('sponsorship'), $req, [
            'suptype' => 'verifikasi',
            'type' => 'sponsorship',
            'with_subquery' => false
        ]);
        
        return view('admin.pages.tverifikasi', [
            'page' => ['title' => 'Verifikasi Sponsorship'],
            'table' => 'sponsorship',
            'data' => $strain->query,
            'filters' => $strain->form_options
        ]);
    }

    public function store(Request $req, Identitas $identitas)
    {
        // Initiation Credentials
        $sponsorship_creden = $req->validate(SponsorshipValidation::getValidations([
            'nama', 'kelas', 'no_wa'
        ]));
        $alerts = [];
        
        try {
            
            // Mock Sponsorship
            $sponsorship_creden['identitas_id'] = $identitas->id;

            // Queue Database Transaction
            $identitas->sponsorship()->create($sponsorship_creden);

            $alerts['success'] = 'Sponsorship berhasil ditambahkan.';
            
            return back()->withErrors([ 'alerts' => $alerts ]);
            
        } catch (\Throwable $th) {
            throw $th;
            return back()->withErrors([
                'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat menambahkan sponsorship.']
            ])->withInput($sponsorship_creden);
        }
    }

    public function update(Request $req, Sponsorship $sponsorship)
    {
        // Initiation Credentials
        $sponsorship_creden = $req->validate(SponsorshipValidation::getValidations([
            'nama', 'kelas', 'no_wa'
        ]));
        $alerts = [];
        
        try {
            
            // Queue Database Transaction
            $sponsorship->update($sponsorship_creden);

            $alerts['success'] = 'Berhasil mengubah data sponsorship.';
            
            return back()->withErrors([ 'alerts' => $alerts ]);
            
        } catch (\Throwable $th) {
            throw $th;
            return back()->withErrors([
                'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat mengubah data sponsorship.']
            ])->withInput($sponsorship_creden);
        }
    }

    public function verifikasi (Request $req, Identitas $identitas)
    {
        // Initiation Credentials
        $verifikasi_creden = [];
        $alerts = [];

        try {

            // Mock Verifikasi
            $verifikasi_creden = [
                'sponsorship' => true,
                'admin_sponsorship_id' => $req->user()->id,
                'tanggal_sponsorship' => now(),
            ];

            $identitas->verifikasi->update($verifikasi_creden);

            $alerts['success'] = 'Sponsorship berhasil diverifikasi.';
            
            return back()->withErrors([ 'alerts' => $alerts ]);
            
        } catch (\Throwable $th) {
            throw $th;
            return back()->withErrors([
                'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat memverifikasi data.']
            ]);
        }
    }

    public function hapus (Sponsorship $sponsorship)
    {
        try {
            $sponsorship->delete();
            return back()->withErrors([
                'alerts' => ['success' => 'Berhasil menghapus sponsorship.']
            ]);
        } catch (\Throwable $th) {
            return back()->withErrors([
                'alerts' => ['success' => 'Maaf, terjadi kesalahan saat menghapus sponsorship.']
            ]);
        }
    }
    
}
