<?php

namespace App\Http\Controllers;

use App\Models\DUSeragam;
use App\Models\Identitas;
use App\Models\Status;
use Illuminate\Http\Request;

class SiswaController extends Controller
{

    protected $validations = [
        'jalur_pendaftaran_id', 
        'sub_jalur_pendaftaran_id', 
        'nama_lengkap', 
        'tanggal_lahir', 
        'jenis_kelamin', 
        'asal_sekolah', 
        'no_wa_siswa', 
        'nama_jurusan',
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

    public function index()
    {
        return view('siswa.pages.index', [
            'page' => ['title' => 'Beranda - Halaman Siswa', 'subtitle' => 'Beranda'],
            'xstatus' => Status::all()
        ]);
    }

    public function daftar_ulang()
    {
        if (auth()->user()->identitas->verifikasi->identitas) {
            return redirect('/siswa')->withErrors([
                'alerts' => ['warning' => 'Maaf, identitas sudah diverifikasi oleh admin dan tidak dapat diubah.']
            ]);
        }
        
        return view('siswa.pages.duseragam', [
            'page' => ['title' => 'Daftar Ulang & Seragam - Halaman Siswa', 'subtitle' => 'Daftar Ulang & Seragam'],
            // 'forms' => FormulirController::getMultiFormInputs(auth()->user()->identitas)
        ]);
    }

    // public function update(Request $req)
    // {
    //     $user = auth()->user();
    //     $creden = $req->validate(Identitas::getValidations($this->validations));
    //     $duscreden = $req->validate(DUSeragam::getValidations($this->duseragamValidations));
    //     $creden = Identitas::getSubPrestasi($creden);

    //     try {
            
    //         $user->identitas->update($creden);
    //         $user->duseragam->update($duscreden);
    //         return redirect('/siswa/profil')->withErrors([
    //             'alerts' => ['success' => 'Profil berhasil diperbarui.']
    //         ]);
            
    //     } catch (\Throwable $th) {
    //         return back()->withErrors([
    //             'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat memproses data.']
    //         ]);
    //     }
        
    // }
    
}
