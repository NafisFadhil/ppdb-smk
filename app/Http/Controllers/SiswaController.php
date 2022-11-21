<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiswaController extends Controller
{

    public function index()
    {
        return view('siswa.pages.index', [
            'page' => ['title' => 'Beranda - Halaman Siswa', 'subtitle' => 'Beranda']
        ]);
    }

    public function profil()
    {
        return view('siswa.pages.profil', [
            'page' => ['title' => 'Edit Profil - Halaman Siswa', 'subtitle' => 'Edit Profil']
        ]);
    }

    public function update(Request $req)
    {
        $user = auth()->user();
        $creden = $req->all();

        try {
            
            $identitas = $user->pendaftaran->identitas->update($creden);
            return redirect('/siswa/profil')->withErrors([
                'alerts' => ['success' => 'Profil berhasil diperbarui.']
            ]);
            
        } catch (\Throwable $th) {
            return back()->withErrors([
                'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat memproses data.']
            ]);
        }
        
    }
    
}
