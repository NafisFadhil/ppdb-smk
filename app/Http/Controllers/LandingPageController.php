<?php

namespace App\Http\Controllers;

use App\Models\Identitas;
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
        
        return view('pages.index', [
            'page' => ['title' => 'PPDB SMK Muhammadiyah Bligo'],
            'siswa' => $siswa
        ]);
    }
    
}
