<?php

namespace App\Http\Controllers;

use App\Models\Identitas;
use App\Models\Jurusan;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class FormulirController extends Controller
{

    protected $myvalidations = [
        'jalur_pendaftaran', 
        'nama_lengkap', 
        'tanggal_lahir', 
        'jenis_kelamin', 
        'asal_sekolah', 
        'no_wa_ortu', 
        'no_wa_siswa', 
        'nama_jurusan', 
    ];

    public function index()
    {
		$jurusan = Jurusan::getOptions();

        return view('pages.formulir', [
            'page' => ['title' => 'Formulir Pendaftaran'],
            'inputs' => [
                ['type' => 'radio', 'name' => 'jalur_pendaftaran', 
                    'values' => ['Umum', 'Prestasi', 'Bintang Kelas'], 
                ],
                ['type' => 'text', 'name' => 'nama_lengkap', 'label' => null, 'placeholder' => null ], 
                ['type' => 'radio', 'name' => 'jenis_kelamin', 'label' => null, 'placeholder' => null,
                    'values' => [ 'Laki-laki', 'Perempuan']
                ],
                ['type' => 'date', 'name' => 'tanggal_lahir', 'label' => null, 'placeholder' => null ], 
                ['type' => 'text', 'name' => 'asal_sekolah', 'label' => null, 'placeholder' => null ], 
                ['type' => 'number', 'name' => 'no_wa_ortu', 'label' => 'WA Ortu/Wali', 'placeholder' => 'Ex. 08123456789' ], 
                ['type' => 'number', 'name' => 'no_wa_siswa', 'label' => 'WA Siswa', 'placeholder' => 'Ex. 08123456789' ], 
                ['type' => 'select', 'name' => 'nama_jurusan', 'label' => null, 'placeholder' => null,
                    'options' => $jurusan
                ],
            ],
        ]);
    }

    public function store(Request $req)
    {
        $creden = $req->validate(Identitas::getValidations($this->myvalidations));

        try {

            $identitas = Identitas::create($creden);
            $pendaftaran = Pendaftaran::create([
                'kode' => Pendaftaran::getKode(),
                'identitas_id' => $identitas->id
            ]);
            
            return redirect('/login')->withErrors([
                'alerts' => ['success' => 'Pendaftaran berhasil.'],
            ]);
            
        } catch (\Exception $th) {

            return back()->withErrors([
                'alerts' => ['error' => 'Maaf, terjadi kesalahan saat memproses data.']
            ])->withInput($creden);

        }
            
    }

    public function edit(Identitas $identitas)
    {
		$jurusan = Jurusan::getOptions();

        return view('layouts.admin-form', [
            'page' => ['title' => 'Edit Data Pendaftaran'],
            'data' => $identitas,
            'form' => [
                'action' => '/admin/edit/'.$identitas->id,
                'button' => [
                    'variant' => 'btn-warning text-white',
                    'content' => '<i class="fas fa-pen"></i> Edit Data',
                ],
                'inputs' => [
                    ['type' => 'radio', 'name' => 'jalur_pendaftaran', 'value' => $identitas->jalur_pendaftaran, 'values' => ['Umum', 'Prestasi', 'Bintang Kelas']],
                    ['name' => 'nama_lengkap', 'value' => $identitas->nama_lengkap],
                    ['name' => 'tanggal_lahir', 'value' => $identitas->tanggal_lahir],
                    ['name' => 'jenis_kelamin', 'value' => $identitas->jenis_kelamin],
                    ['name' => 'asal_sekolah', 'value' => $identitas->asal_sekolah],
                    ['type' => 'number', 'name' => 'no_wa_ortu', 'value' => $identitas->no_wa_ortu],
                    ['type' => 'number', 'name' => 'no_wa_siswa', 'value' => $identitas->no_wa_siswa],
                    ['name' => 'keterangan', 'value' => $identitas->pendaftaran->keterangan],
                    ['type' => 'select', 'name' => 'nama_jurusan', 'value' => $identitas->nama_jurusan, 'options' => $jurusan],
                ]
            ],
        ]);
    }

    public function update(Request $req, Identitas $identitas)
    {

        $creden = $req->validate(Identitas::getValidations($this->myvalidations));

        $identitas = Identitas::where('id', $identitas->id)->update($creden);

        if ($identitas) return redirect('/admin/peserta')->withErrors([
            'alerts' => ['success' => 'Data peserta berhasil diubah.']
        ]);

        return back()->withErrors([
            'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat mengubah data.']
        ])->withInput($creden);
    }
    
}
