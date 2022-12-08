<?php

namespace App\Http\Controllers;

use App\Models\Identitas;
use App\Models\Pendaftaran;
use App\Models\Sponsorship;
use Illuminate\Http\Request;

class SponsorshipController extends Controller
{

    protected $validations = [
        'nama' => 'required|string',
        'kelas' => 'required|string',
        'no_wa' => 'required|numeric',
        'identitas_id' => 'required|numeric',
    ];
    
    public function index()
    {
        return view('admin.pages.sponsorship', [
            'page' => ['title' => 'Data Sponsorship'],
            'sponsorship' => Sponsorship::latest()->with(['identitas'])->paginate(),
            'peserta' => Identitas::select(['id', 'nama_lengkap', 'asal_sekolah'])->get()
        ]);
    }

    public function store(Request $req)
    {
        $creden = $req->validate($this->validations);

        $sponsorship = Sponsorship::create($creden);

        if ($sponsorship) return redirect('/admin/sponsorship')->withErrors([
            'alerts' => ['success' => 'Sponsorship berhasil ditambahkan.']
        ]);

        return back()->withErrors([
            'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat menambahkan data.']
        ])->withInput($creden);
    }

    public function edit(Sponsorship $sponsorship)
    {
        $peserta = Identitas::select(['id', 'nama_lengkap', 'asal_sekolah'])->get();
        $newpeserta = ['Pilih Siswa'];
        foreach ($peserta as $item) {
            $newpeserta[] = ['value' => $item->id, 'label' => "$item->nama_lengkap ($item->asal_sekolah)"];
        }
        return view('admin.pages.forms', [
            'page' => ['title' => 'Edit Data Sponsorship'],
            'data' => $sponsorship,
            'form' => [
                'action' => '/admin/sponsorship/edit/'.$sponsorship->id,
                'button' => [
                    'variant' => 'btn-warning text-white',
                    'content' => '<i class="fa fa-pen"></i> Edit Data',
                ],
                'inputs' => [
                    ['name' => 'nama', 'value' => $sponsorship->nama],
                    ['name' => 'kelas', 'value' => $sponsorship->kelas],
                    ['name' => 'no_wa', 'value' => $sponsorship->no_wa],
                    ['type' => 'select2', 'name' => 'identitas_id', 'value' => $sponsorship->identitas_id, 'options' => $newpeserta],
                ]
            ],
        ]);
    }
    
    public function update(Request $req, Sponsorship $sponsorship)
    {
        $creden = $req->validate($this->validations);

        $sponsorship = Sponsorship::where('id', $sponsorship->id)->update($creden);

        if ($sponsorship) return redirect('/admin/sponsorship')->withErrors([
            'alerts' => ['success' => 'Data sponsorship berhasil diubah.']
        ]);

        return back()->withErrors([
            'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat mengubah data.']
        ])->withInput($creden);
    }
    
}
