<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Sponsorship;
use Illuminate\Http\Request;

class SponsorshipController extends Controller
{
    public function index()
    {
        return view('admin.pages.sponsorship', [
            'page' => ['title' => 'Data Sponsorship'],
            'sponsorship' => Sponsorship::latest()->with(['pendaftaran'])->paginate(),
            'pendaftaran' => Pendaftaran::with(['identitas'])->get()
        ]);
    }

    public function store(Request $req)
    {
        $creden = $req->validate([
            'nama_sponsorship' => 'required|string',
            'kelas_sponsorship' => 'required|string',
            'no_wa_sponsorship' => 'required|numeric',
            'pendaftaran_id' => 'required|numeric',
        ]);

        $sponsorship = Sponsorship::create($creden);

        if ($sponsorship) return redirect('/admin/sponsorship')->withErrors([
            'alerts' => ['success' => [
                'msg' => 'Sponsorship berhasil ditambahkan.'
            ]]
        ]);

        return back()->withErrors([
            'alerts' => ['danger' => [
                'msg' => 'Maaf, terjadi kesalahan saat menambahkan data.'
            ]]
        ])->withInput($creden);
    }
}
