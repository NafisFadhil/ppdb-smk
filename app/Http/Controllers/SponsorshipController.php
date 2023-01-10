<?php

namespace App\Http\Controllers;

use App\Models\Identitas;
use App\Models\Sponsorship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SponsorshipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $options = [['label' => '-- Pilih Siswa --', 'value' => '']];
        $models = Identitas::with(['pendaftaran', 'sponsorship'])
        ->join('pendaftarans', 'pendaftarans.identitas_id', 'identitas.id')
        ->orderBy('pendaftarans.kode', 'ASC')->cursor();

        foreach ($models as $row) {
            $label = $row->pendaftaran->kode . ' - ' . $row->nama_lengkap . ' (' . $row->asal_sekolah . ')';
            $options[] = ['label' => $label, 'value' => $row->id];
        }

        return view('admin.pages.forms', [
            'page' => ['title' => 'Tambah Sponsorship'],
            'form' => [
                'action' => '/admin/sponsorship',
                'button' => [
                    'variant' => 'primary text-white',
                    'content' => '<i class="fa fa-plus"></i> Tambah Sponsorship',
                ],
                'inputs' => [
                    ['name' => 'nama', 'opts' => ['required', 'uppercase']],
                    ['name' => 'kelas', 'opts' => ['required', 'uppercase']],
                    ['type' => 'number', 'name' => 'no_wa', 'opts' => ['required']],
                    [
                        'type' => 'select2', 'name' => 'identitas_id', 'label' => 'Identitas',
                        'options' => $options, 'opts' => ['required'], 'attr' => 'sponsorship-siswa-selector="/admin/verifikasi/sponsorship"'
                    ]
                ]
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sponsorship  $sponsorship
     * @return \Illuminate\Http\Response
     */
    public function show(Sponsorship $sponsorship)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sponsorship  $sponsorship
     * @return \Illuminate\Http\Response
     */
    public function edit(Sponsorship $sponsorship)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sponsorship  $sponsorship
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sponsorship $sponsorship)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sponsorship  $sponsorship
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sponsorship $sponsorship)
    {
        //
    }
}
