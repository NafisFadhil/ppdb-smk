<?php

namespace App\Http\Controllers\Verifikasi;

use App\Filters\Filter;
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
        $data = Filter::filter($this->getModel(), $req);
        
        return view('admin.pages.table', [
            'page' => ['title' => 'Verifikasi Pendataan'],
            'table' => 'verifikasi-pendataan',
            'peserta' => $data,
            'filters' => [
                [
                    ['type' => 'search', 'name' => 'search', 'placeholder' => 'Cari peserta...'],
                ],
                [
                    ['type' => 'select', 'name' => 'jurusan', 'options' => Jurusan::getOptions()],
                    ['type' => 'select', 'name' => 'jalur', 'options' => DataJalurPendaftaran::getAdvancedOptions()],
                ],
                [
                    ['type' => 'select', 'name' => 'tanggal', 'options' => Filter::getTanggalOptions()],
                    ['type' => 'select', 'name' => 'bulan', 'options' => Filter::getBulanOptions()],
                    ['type' => 'select', 'name' => 'tahun', 'options' => Filter::getTahunOptions()],

                    ['type' => 'select', 'name' => 'perPage', 'options' => [
                        ['label' => '-- Per Page --', 'value' => ''],
                        5,10,15,20,25,50,100
                    ]],
                ]
            ]
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
