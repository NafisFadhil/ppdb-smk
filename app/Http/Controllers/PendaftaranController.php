<?php

namespace App\Http\Controllers;

use App\Models\Identitas;
use App\Models\Pendaftaran;
use App\Validator\Pendaftaran as ValidatorPendaftaran;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.pendaftaran', [
            'page' => ['title' => 'Formulir Pendaftaran'],
            'inputs' => \App\Metaform::pendaftaran()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        $credentials = ValidatorPendaftaran::validate($req);

        try {
            $identitas = Identitas::create($credentials);
            $pendaftaran = Pendaftaran::create([
                'kode' => Pendaftaran::get_kode($identitas->id),
                'identitas_id' => $identitas->id
            ]);
        } catch (\Throwable $th) {
            throw $th;
            return back()->withErrors([
                'alerts' => [
                    'error' => 'Maaf, terjadi kesalahan saat memasukkan data.'
                ]
            ])->withInput($credentials);
        }

        return redirect('/pendaftaran')->withErrors([
            'alerts' => ['success' => 'Pendaftaran berhasil.']
        ]);
        
        return $credentials;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pendaftaran  $pendaftaran
     * @return \Illuminate\Http\Response
     */
    public function show(Pendaftaran $pendaftaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pendaftaran  $pendaftaran
     * @return \Illuminate\Http\Response
     */
    public function edit(Pendaftaran $pendaftaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $req
     * @param  \App\Models\Pendaftaran  $pendaftaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, Pendaftaran $pendaftaran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pendaftaran  $pendaftaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pendaftaran $pendaftaran)
    {
        //
    }
}
