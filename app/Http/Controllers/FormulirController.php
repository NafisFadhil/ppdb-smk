<?php

namespace App\Http\Controllers;

use App\Metadata\Jurusan as MetadataJurusan;
use App\Metadata\Pendaftaran as MetadataPendaftaran;
use App\Metadata\Formulir as MetadataFormulir;
use App\Metadata\Seragam as MetadataSeragam;
use App\Models\Identitas;
use App\Models\Jurusan;
use App\Models\Pembayaran;
use App\Models\Pendaftaran;
use App\Models\Seragam;
use App\Models\User;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class FormulirController extends Controller
{

    public function index()
    {
        return view('pages.formulir', [
            'page' => ['title' => 'Formulir Pendaftaran'],
            'inputs' => MetadataFormulir::inputs(),
            // 'pendaftaran' => Pendaftaran::all()->first()
        ]);
    }

    public function store(Request $req)
    {
        $creden = $req->validate(MetadataFormulir::validator());

        try {

            $kode = Pendaftaran::getKode();
            $identitas = Identitas::create($creden);
            $pembayaran = Pembayaran::create(['bool' => true]);
            $pendaftaran = Pendaftaran::create([
                'kode' => $kode,
                'identitas_id' => $identitas->id,
                'pembayaran_id' => $pembayaran->id,
            ]);
            
        } catch (\Exception $th) {

            return back()->withErrors([
                'alerts' => ['error' => 'Maaf, terjadi kesalahan saat memproses data.']
            ])->withInput($creden);

        }

        return redirect('/login')->withErrors([
            'alerts' => ['success' => 'Pendaftaran berhasil.'],
        ]);
            
    }

    public function edit(Pendaftaran $pendaftarans)
    {
        $new_jurusan = [['value' => '', 'label' => 'Pilih Jurusan']];
		$jurusan = Jurusan::$jurusan;
		foreach ($jurusan as $jrsn) $new_jurusan[] = [
			'label' => $jrsn['nama'], 'value' => $jrsn['slug']
		];

        return view('admin.pages.edit', [
            'page' => ['title' => 'Edit Data Pendaftaran'],
            'data' => $pendaftarans,
            'form' => [
                'action' => '/admin/edit/'.$pendaftarans->identitas->id,
                'button' => [
                    'variant' => 'btn-warning text-white',
                    'content' => '<i class="fas fa-pen"></i> Edit Data',
                ],
                'inputs' => [
                    ['type' => 'radio', 'name' => 'jalur_pendaftaran', 'value' => $pendaftarans->identitas->jalur_pendaftaran, 'values' => ['Umum', 'Prestasi', 'Bintang Kelas']],
                    ['name' => 'nama_lengkap', 'value' => $pendaftarans->identitas->nama_lengkap],
                    ['name' => 'tanggal_lahir', 'value' => $pendaftarans->identitas->tanggal_lahir],
                    ['name' => 'jenis_kelamin', 'value' => $pendaftarans->identitas->jenis_kelamin],
                    ['name' => 'asal_sekolah', 'value' => $pendaftarans->identitas->asal_sekolah],
                    ['type' => 'number', 'name' => 'no_wa_ortu', 'value' => $pendaftarans->identitas->no_wa_ortu],
                    ['type' => 'number', 'name' => 'no_wa_siswa', 'value' => $pendaftarans->identitas->no_wa_siswa],
                    ['type' => 'select', 'name' => 'nama_jurusan', 'value' => $pendaftarans->identitas->nama_jurusan, 'options' => $new_jurusan],
                ]
            ],
        ]);
    }

    public function update(Request $req, Pendaftaran $pendaftarans)
    {

        $creden = $req->validate([
            'jalur_pendaftaran' => 'required',
            'nama_lengkap' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'asal_sekolah' => 'required',
            'no_wa_ortu' => 'required',
            'no_wa_siswa' => 'required',
            'nama_jurusan' => 'required',
        ]);

        $identitas = Identitas::where('id', $pendaftarans->id)->update($creden);

        if ($identitas) return redirect('/admin/peserta')->withErrors([
            'alerts' => ['success' => [
                'msg' => 'Data peserta berhasil diubah.'
            ]]
        ]);

        return back()->withErrors([
            'alerts' => ['danger' => [
                'msg' => 'Maaf, terjadi kesalahan saat mengubah data.'
            ]]
        ]);
    }
    
}
