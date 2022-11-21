<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    
    public function index()
    {
        return view('admin.pages.index', [
            'page' => ['title' => 'Dashboard Admin PPDB'],
            'pendaftaran' => Pendaftaran::with('level')->get()
        ]);
    }

    public function peserta()
    {
        $search = request('search') ?? false;
        if ($search) {
            $peserta = Pendaftaran::whereRelation('identitas', 'nama_lengkap', 'like', "%$search%")
                ->latest()->paginate(25);
        } else $peserta = Pendaftaran::latest()->with(['identitas', 'user', 'pembayaran'])->paginate(25);

        return view('admin.pages.peserta', [
            'page' => ['title' => 'Daftar Peserta'],
            'peserta' => $peserta
        ]);
    }
    
}
