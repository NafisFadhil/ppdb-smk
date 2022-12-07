<?php

namespace App\Http\Controllers;

use App\Models\Identitas;
use App\Models\JalurPendaftaran;
use App\Models\Jurusan;
use App\Models\Pendaftaran;
use App\Models\Tagihan;
use Illuminate\Http\Request;

class FormulirController extends Controller
{

    protected $myValidations = [
        'jalur_pendaftaran_id', 
        'nama_lengkap', 
        'tanggal_lahir', 
        'jenis_kelamin', 
        'asal_sekolah', 
        'no_wa_siswa', 
        'nama_jurusan', 
    ];

    protected $myAdvancedValidations = [
        'jalur_pendaftaran_id', 
        'nama_lengkap', 
        'tanggal_lahir', 
        'jenis_kelamin', 
        'asal_sekolah', 
        'no_wa_siswa', 
        'nama_jurusan', 
    ];

    protected function getFormInputs ($data = [])
    {
        $jurusan = Jurusan::getOptions();
        $jalurs = JalurPendaftaran::getOptions();

        return [
            ['type' => 'radio', 'name' => 'jalur_pendaftaran_id', 'value' => $data['jalur_pendaftaran_id'],
                'label' => 'Jalur Pendaftaran', 'values' => $jalurs
            ],
            ['type' => 'text', 'name' => 'nama_lengkap', 'value' => $data['nama_lengkap'],
                'label' => null, 'placeholder' => null ], 
            ['type' => 'radio', 'name' => 'jenis_kelamin', 'value' => $data['jenis_kelamin'],
                'label' => null, 'placeholder' => null, 'values' => [ 'Laki-laki', 'Perempuan']
            ],
            ['type' => 'date', 'name' => 'tanggal_lahir', 'value' => $data['tanggal_lahir'],
                'label' => null, 'placeholder' => null ], 
            ['type' => 'text', 'name' => 'asal_sekolah', 'value' => $data['asal_sekolah'],
                'label' => null, 'placeholder' => null ], 
            ['type' => 'number', 'name' => 'no_wa_siswa', 'value' => $data['no_wa_siswa'],
                'label' => 'WA Siswa', 'placeholder' => 'Cth. 08123456789' ], 
            ['type' => 'select', 'name' => 'nama_jurusan', 'value' => $data['nama_jurusan'],
                'label' => null, 'placeholder' => null, 'options' => $jurusan
            ],
        ];
    }

    protected function getAdvancedFormInputs ($data = [])
    {
        $jurusan = Jurusan::getOptions();
        $jalurs = JalurPendaftaran::getAdvancedOptions();

        return [
            ['type' => 'select', 'name' => 'jalur_pendaftaran_id', 'value' => $data['jalur_pendaftaran_id'],
                'label' => 'Jalur Pendaftaran', 'options' => $jalurs],
            ['type' => 'text', 'name' => 'nama_lengkap', 'value' => $data['nama_lengkap'],
                'label' => null, 'placeholder' => null ], 
            ['type' => 'radio', 'name' => 'jenis_kelamin', 'value' => $data['jenis_kelamin'],
                'label' => null, 'placeholder' => null, 'values' => [ 'Laki-laki', 'Perempuan'] ],
            ['type' => 'date', 'name' => 'tanggal_lahir', 'value' => $data['tanggal_lahir'],
                'label' => null, 'placeholder' => null ], 
            ['type' => 'text', 'name' => 'asal_sekolah', 'value' => $data['asal_sekolah'],
                'label' => null, 'placeholder' => null ], 
            ['type' => 'number', 'name' => 'no_wa_siswa', 'value' => $data['no_wa_siswa'],
                'label' => 'WA Siswa', 'placeholder' => 'Cth. 08123456789' ], 
            ['type' => 'select', 'name' => 'nama_jurusan', 'value' => $data['nama_jurusan'],
                'label' => null, 'placeholder' => null, 'options' => $jurusan],
        ];
    }

    public function index ()
    {
        return view('pages.formulir', [
            'page' => ['title' => 'Formulir Pendaftaran'],
            'inputs' => $this->getFormInputs(),
        ]);
    }

    public function tambah ()
    {
        return view('admin.pages.forms', [
            'page' => ['title' => 'Tambah Pendaftaran'],
            'inputs' => $this->getAdvancedFormInputs(),
        ]);
    }

    public function store(Request $req)
    {
        $creden = $req->validate(Identitas::getValidations($this->myValidations));
        // $creden['nama_lengkap'] = strtoupper($creden['nama_lengkap']);
        // $creden['asal_sekolah'] = strtoupper($creden['asal_sekolah']);
        
        try {

            $identitas = Identitas::create($creden);
            $tagihan = Tagihan::create([
                'biaya_pendaftaran' => $identitas->jalur_pendaftaran->biaya_pendaftaran,
                'tagihan_pendaftaran' => $identitas->jalur_pendaftaran->biaya_pendaftaran,
                'biaya_daftar_ulang' => $identitas->jalur_pendaftaran->biaya_daftar_ulang,
                'tagihan_daftar_ulang' => $identitas->jalur_pendaftaran->biaya_daftar_ulang,
                'biaya_seragam' => $identitas->jalur_pendaftaran->biaya_seragam,
                'tagihan_seragam' => $identitas->jalur_pendaftaran->biaya_seragam,
                'identitas_id' => $identitas->id,
            ]);
            $pendaftaran = Pendaftaran::create([
                'kode' => Pendaftaran::getKode(),
                'identitas_id' => $identitas->id
            ]);
            
            return redirect('/login')->withErrors([
                'alerts' => ['success' => 'Pendaftaran berhasil.'],
            ]);
            
        } catch (\Exception $th) {
            throw $th;
            return back()->withErrors([
                'alerts' => ['error' => 'Maaf, terjadi kesalahan saat memproses data.']
            ])->withInput($creden);

        }
            
    }

    public function edit(Identitas $identitas)
    {
        return view('admin.pages.forms', [
            'page' => ['title' => 'Edit Data Pendaftaran'],
            'data' => $identitas,
            'form' => [
                'action' => '/admin/edit/'.$identitas->id,
                'button' => [
                    'variant' => 'btn-warning text-white',
                    'content' => '<i class="fa fa-pen"></i> Edit Data',
                ],
                'inputs' => $this->getAdvancedFormInputs($identitas)
            ],
        ]);
    }

    public function update(Request $req, Identitas $identitas)
    {

        $creden = $req->validate(Identitas::getValidations($this->myAdvancedValidations));

        try {
            
            $identitas = Identitas::where('id', $identitas->id)->update($creden);
            return redirect('/admin/peserta')->withErrors([
                'alerts' => ['success' => 'Data peserta berhasil diubah.']
            ]);
            
        } catch (\Throwable $th) {
            return back()->withErrors([
                'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat memperbarui data.']
            ])->withInput($creden);
        }

    }
    
}
