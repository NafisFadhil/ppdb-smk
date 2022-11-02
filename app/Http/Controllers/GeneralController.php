<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneralController extends Controller
{

    public function index()
    {
        return view('pages.index', [
            'page' => ['title' => 'PPDB SMK Muhammadiyah Bligo'],
        ]);
    }

    public function formulir()
    {
        return view('pages.formulir', [
            'page' => ['title' => 'Formulir Pendaftaran']
        ]);
    }

}
