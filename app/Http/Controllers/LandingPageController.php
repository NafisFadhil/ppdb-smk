<?php

namespace App\Http\Controllers;

use App\Models\Identitas;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LandingPageController extends Controller
{
    
    public function index()
    {
        $siswa = [];
        $pasca = Session::has('session_id');
        if ($pasca) {
            $siswa = Identitas::with(['tagihan', 'pendaftaran'])
                ->where('session_id', Session::get('session_id'))->get();
        }

        $duplicated = Session::has('session_duplicated');
        if ($duplicated) {
            $siswa = Identitas::with(['tagihan', 'pendaftaran'])
                ->where('session_id', Session::get('session_duplicated'))->get();
        }

        $data_jurusan = Jurusan::getJurusans();
        
        return view('pages.index', [
            'page' => ['title' => 'PPDB 2023 | SMK Muhammadiyah Bligo'],
            'data_jurusan' => $data_jurusan,
            'siswa' => $siswa
        ]);
    }

    public function kontak ()
    {
        $kontak = ['085780190170', '081391870500'];
        $sosmed = [
            'instagram' => [
                'icon' => 'fab fa-instagram',
                'href' => 'http://www.instagram.com/smkmuhbligo_ig',
                'label' => 'smkmuhbligo_ig'
            ],
            'facebook' => [
                'icon' => 'fab fa-facebook',
                'href' => 'https://www.facebook.com/profile.php?id=100015024096175',
                'label' => 'Smk Muhammadiyah Bligo'
            ],
            'envelope' => [
                'icon' => 'fas fa-envelope',
                'href' => 'mailto://smkmuhbligo2003@gmail.com',
                'label' => 'smkmuhbligo2003@gmail.com'
            ]
        ];
        
        return view('pages.kontak', [
            'page' => ['title' => 'Kontak'],
            'data_kontak' => $kontak,
            'data_sosmed' => $sosmed
        ]);
    }
    
}
