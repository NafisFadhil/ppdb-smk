<?php

namespace App\Http\Controllers;

use App\Models\DUSeragam;
use App\Models\Identitas;
use Illuminate\Http\Request;

class DUSeragamController extends Controller
{
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
        $creden = $req->validate(Identitas::getValidations(DUSeragam::$validations));

        $seragamCreden = $req->validate([
            'ukuran_seragam' => 'required'
        ]);

        try {

            $user = $req->user();
            $identitas = $user->identitas;
            $iden = $identitas->update([
                'status_id' => $user->identitas->status_id+1,
                ...$creden,
            ]);
            $duseragam = $identitas->duseragam->update([
                ...$seragamCreden
            ]);

            return redirect('/siswa')->withErrors([
                'alerts' => ['success' => 'Daftar ulang berhasil.']
            ]);

        } catch (\Throwable $th) {
            return back()->withErrors([
                'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat memproses daftar ulang.']
            ])->withInput([...$creden, ...$seragamCreden]);
        }
    }
}
