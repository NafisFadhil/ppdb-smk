<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;

class GeneralController extends Controller
{

    public function index()
    {
        return view('pages.index', [
            'page' => ['title' => 'PPDB SMK Muhammadiyah Bligo'],
        ]);
    }

}
