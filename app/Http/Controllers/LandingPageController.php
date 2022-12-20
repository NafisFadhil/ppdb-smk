<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    
    public function index()
    {
        return view('pages.index', [
            'page' => ['title' => 'PPDB SMK Muhammadiyah Bligo'],
        ]);
    }
    
}
