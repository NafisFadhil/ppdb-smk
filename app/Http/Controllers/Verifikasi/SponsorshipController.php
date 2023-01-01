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
use App\Validations\SponsorshipValidation;
use Illuminate\Http\Request;

class SponsorshipController extends Controller
{

    private function getModel() {
        return Identitas::with([
            'sponsorship', 'jenis_kelamin', 'jalur_pendaftaran', 'jurusan', 'verifikasi'
        ])->has('sponsorship');
    }
    
    public function index(Request $req)
    {
        session(['oldpath' => request()->path()]);
        $data = Filter::filter($this->getModel(), $req, 'verifikasi', 'sponsorship', 
            filters: [
                'search' => [
                    'wheres' => [
                        'whereRelation' => ['sponsorship', 'nama', 'LIKE'],
                        'orWhereRelation' => ['sponsorship', 'kelas', 'LIKE'],
                        'orWhereRelation' => ['sponsorship', 'no_wa', 'LIKE'],
                        'orWhereRelation' => ['pendaftaran', 'kode', 'LIKE'],
                        'orWhereRelation' => ['jurusan', 'kode', 'LIKE'],
                        'orWhere' => ['identitas', 'nama_lengkap', 'LIKE'],
                        'orWhere' => ['identitas', 'asal_sekolah', 'LIKE'],
                    ]
                ]
            ]
        );
        
        return view('admin.pages.table', [
            'page' => ['title' => 'Verifikasi Sponsorship'],
            'table' => 'verifikasi-sponsorship',
            'data' => $data,
            'filters' => [
                [
                    ['type' => 'search', 'name' => 'search', 'placeholder' => 'Cari peserta...'],
                ],
                [
                    ['type' => 'select', 'name' => 'jurusan', 'options' => Jurusan::getOptions()],
                    ['type' => 'select', 'name' => 'jalur', 'options' => DataJalurPendaftaran::getAdvancedOptions()],
                ],
                [
                    ['type' => 'select', 'name' => 'tanggal', 'options' => FilterOptions::getTanggalOptions()],
                    ['type' => 'select', 'name' => 'bulan', 'options' => FilterOptions::getBulanOptions()],
                    ['type' => 'select', 'name' => 'tahun', 'options' => FilterOptions::getTahunOptions()],

                    ['type' => 'select', 'name' => 'perPage', 'options' => [
                        ['label' => '-- Per Page --', 'value' => ''],
                        5,10,15,20,25,50,100
                    ]],
                ]
            ]
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
            dispatch_sync(function () use (
                $sponsorship_creden, $identitas
            ) {
                $identitas->sponsorship()->create($sponsorship_creden);
            });

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
            dispatch_sync(function () use (
                $sponsorship_creden, $sponsorship
            ) {
                $sponsorship->update($sponsorship_creden);
            });

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

            dispatch_sync(function () use (
                $verifikasi_creden, $identitas
            ) {
                $identitas->verifikasi->update($verifikasi_creden);
            });

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
