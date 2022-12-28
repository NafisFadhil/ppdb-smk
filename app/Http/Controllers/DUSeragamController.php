<?php

namespace App\Http\Controllers;

use App\Models\DUSeragam;
use App\Models\Identitas;
use App\Models\JalurPendaftaran;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class DUSeragamController extends Controller
{
    protected $validations = [
        // 'jalur_pendaftaran_id', 
        // 'nama_lengkap', 
        // 'tanggal_lahir', 
        // 'jenis_kelamin', 
        // 'asal_sekolah', 
        // 'no_wa_siswa', 
        // 'nama_jurusan',
        // Advanced Form Inputs
        'no_wa_ortu',
        'tempat_lahir',
        'alamat_desa',
        'alamat_kec',
        'alamat_kota_kab',
        'alamat_rt',
        'alamat_rw',
        'nama_ayah',
        'nama_ibu',
        'jumlah_saudara_kandung',
        'nik',
        'nisn',
        'no_ujian_nasional',
        'no_ijazah',
    ];

    protected $duseragamValidations = [
        'ukuran_seragam'
    ];
    
    protected function getAdvancedFormInputs (Identitas $data = null)
    {
        $jurusan = Jurusan::getOptions();
        $jalurs = DataJalurPendaftaran::getAdvancedOptions();
        $kelamins = ['LAKI-LAKI', 'PEREMPUAN'];

        return [
            ['type' => 'select', 'name' => 'jalur_pendaftaran_id', 'value' => $data->jalur_pendaftaran_id??null,
                'label' => 'Jalur Pendaftaran', 'options' => $jalurs, 'opts' => ['required'], 'attr' => 'disabled'],
            ['type' => 'text', 'name' => 'nama_lengkap', 'value' => $data->nama_lengkap??null,
                'label' => null, 'placeholder' => null, 'opts' => ['required'], 'attr' => 'disabled'], 
            ['type' => 'text', 'name' => 'tempat_lahir', 'value' => $data->tempat_lahir??null,
                'label' => null, 'placeholder' => null],
            ['type' => 'date', 'name' => 'tanggal_lahir', 'value' => $data->tanggal_lahir??null,
                'label' => null, 'placeholder' => null, 'opts' => ['required'], 'attr' => 'disabled'], 
            ['type' => 'radio', 'name' => 'jenis_kelamin', 'value' => $data->jenis_kelamin??null,
                'label' => null, 'placeholder' => null, 'values' => $kelamins, 'opts' => ['required'], 'attr' => 'disabled'],
            ['type' => 'text', 'name' => 'alamat_desa', 'value' => $data->alamat_desa??null,
                'label' => null, 'placeholder' => null],
            ['type' => 'text', 'name' => 'alamat_kec', 'value' => $data->alamat_kec??null,
                'label' => null, 'placeholder' => null],
            ['type' => 'text', 'name' => 'alamat_kota_kab', 'value' => $data->alamat_kota_kab??null,
                'label' => null, 'placeholder' => null],
            ['type' => 'number', 'name' => 'alamat_rt', 'value' => $data->alamat_rt??null,
                'label' => null, 'placeholder' => null],
            ['type' => 'number', 'name' => 'alamat_rw', 'value' => $data->alamat_rw??null,
                'label' => null, 'placeholder' => null],
            ['type' => 'text', 'name' => 'nama_ayah', 'value' => $data->nama_ayah??null,
                'label' => null, 'placeholder' => null],
            ['type' => 'text', 'name' => 'nama_ibu', 'value' => $data->nama_ibu??null,
                'label' => null, 'placeholder' => null],
            ['type' => 'number', 'name' => 'jumlah_saudara_kandung', 'value' => $data->jumlah_saudara_kandung??null,
                'label' => null, 'placeholder' => null],
            ['type' => 'number', 'name' => 'nik', 'value' => $data->nik??null,
                'label' => null, 'placeholder' => null],
            ['type' => 'text', 'name' => 'asal_sekolah', 'value' => $data->asal_sekolah??null,
                'label' => null, 'placeholder' => null, 'opts' => ['required'], 'attr' => 'disabled'], 
            ['type' => 'number', 'name' => 'nisn', 'value' => $data->nisn??null,
                'label' => null, 'placeholder' => null],
            ['type' => 'number', 'name' => 'no_ujian_nasional', 'value' => $data->no_ujian_nasional??null,
                'label' => null, 'placeholder' => null],
            ['type' => 'number', 'name' => 'no_ijazah', 'value' => $data->no_ijazah??null,
                'label' => null, 'placeholder' => null],
            ['type' => 'number', 'name' => 'no_wa_siswa', 'value' => $data->no_wa_siswa??null,
                'label' => 'No WA Siswa', 'placeholder' => 'Cth. 08123456789', 'opts' => ['required'], 'attr' => 'disabled'], 
            ['type' => 'number', 'name' => 'no_wa_ortu', 'value' => $data->no_wa_ortu??null,
                'label' => null, 'placeholder' => null],
            ['type' => 'select', 'name' => 'nama_jurusan', 'value' => $data->nama_jurusan??null,
                'label' => null, 'placeholder' => null, 'options' => $jurusan, 'opts' => ['required'], 'attr' => 'disabled'],
            ['type' => 'select', 'name' => 'ukuran_seragam', 'value' => $data->duseragam->ukuran_seragam??null, 'options' => [
                ['label' => '--Pilih Ukuran Seragam--', 'value' => ''],
                'S', 'M', 'L', 'XL', 'XXL', 'XXXL'
            ]],
        ];
    }
    
    public function index()
    {
        return view('siswa.pages.duseragam', [
            'page' => [
                'title' => 'Daftar Ulang & Seragam - Halaman Siswa',
                'subtitle' => 'Daftar Ulang & Seragam'
            ]
        ]);
    }

    public function store(Request $req)
    {
        $creden = $req->validate(Identitas::getValidations($this->validations));
        $seragamCreden = $req->validate(DUSeragam::getValidations($this->duseragamValidations));

        try {

            $user = $req->user();
            $user->identitas->duseragam->update($seragamCreden);
            $user->identitas->update($creden);

            return redirect('/siswa')->withErrors([
                'alerts' => ['success' => 'Daftar ulang berhasil.']
            ]);

        } catch (\Throwable $th) {
            return back()->withErrors([
                'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat memproses daftar ulang.']
            ])->withInput([...$creden, ...$seragamCreden]);
        }
    }

    public function admcreate(Identitas $identitas)
    {
        return view('admin.pages.forms', [
            'page' => ['title' => 'Formulir DU & Seragam'],
            'data' => $identitas,
            'form' => [
                'action' => '/admin/formulir-duseragam/'.$identitas->id,
                'button' => [
                    'variant' => 'primary text-white',
                    'content' => '<i class="fa">SUBMIT</i>',
                ],
                'inputs' => $this->getAdvancedFormInputs($identitas)
            ],
        ]);
    }

    public function admstore(Request $req, Identitas $identitas)
    {
        $creden = $req->validate(Identitas::getValidations($this->admValidations));
        $duscreden = $req->validate(DUSeragam::getValidations($this->duseragamValidations));

        try {

            $identitas->update([
                'status_id' => $identitas->status_id + 1,
                ...$creden,
            ]);
            $identitas->duseragam->update($duscreden);

            return redirect('/admin/verifikasi/duseragam')->withErrors([
                'alerts' => ['success' => 'Daftar ulang berhasil.']
            ]);

        } catch (\Throwable $th) {
            return back()->withErrors([
                'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat memproses daftar ulang.']
            ])->withInput([...$creden, ...$duscreden]);
        }
    }
}
