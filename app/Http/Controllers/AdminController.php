<?php

namespace App\Http\Controllers;

use App\Models\Identitas;

class AdminController extends Controller
{
    
    public function index()
    {
        return view('admin.pages.index', [
            'page' => ['title' => 'Dashboard Admin PPDB'],
            'peserta' => Identitas::select(['status_id'])->with('status')->get()
        ]);
    }

    public function peserta()
    {
        $search = request('search') ?? false;
        if ($search) {
            $peserta = Identitas::where('nama_lengkap', 'like', "%$search%")
                ->latest()->paginate(25);
        } else $peserta = Identitas::latest()->with(['pendaftaran', 'user', 'status'])->paginate();

        return view('admin.pages.peserta', [
            'page' => ['title' => 'Daftar Peserta'],
            'peserta' => $peserta
        ]);
    }
    
}
