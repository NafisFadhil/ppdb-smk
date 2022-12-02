<?php

namespace App\Http\Controllers;

use App\Models\DaftarUlang;
use App\Models\Identitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DaftarUlangController extends Controller
{
    public function index()
    {
        return view('siswa.pages.daftar-ulang', [
            'page' => ['title' => 'Daftar Ulang - Halaman Siswa', 'subtitle' => 'Daftar Ulang']
        ]);
    }

    public function store(Request $req)
    {
        try {

            $user = Auth::user();
            $creden = $req->validate(DaftarUlang::$validations);
            $identitas = $user->identitas->update([
                ...$creden,
                'status_id' => $user->identitas->status_id+1
            ]);
            $du = DaftarUlang::create([ 'identitas_id' => $user->identitas_id ]);

            return redirect('/siswa')->withErrors([
                'alerts' => ['success' => 'Daftar ulang berhasil.']
            ]);

        } catch (\Throwable $th) {
            return back()->withErrors([
                'alerts' => ['danger' => 'Maaf, terjadi kesalahan. Silahkan coba lagi.']
            ]);
        }
    }
}
