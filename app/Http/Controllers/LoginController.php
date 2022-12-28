<?php

namespace App\Http\Controllers;

use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    
    public function index()
    {
        return view('pages.login', [
            'page' => ['title' => 'Halaman Login Siswa'],
            'inputs' => [
                ['type' => 'text', 'name' => 'username', 'label' => 'Kode Jurusan', 'attr' => 'autofocus', 'opts' => ['uppercase']],
                ['type' => 'date', 'name' => 'password', 'label' => 'Tanggal Lahir'],
            ]
        ]);
    }

    public function login(Request $req)
    {
        $creden = $req->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Mock User
        $creden['password'] = Date::createFromFormat('Y-m-d', $creden['password']);
        $creden['password'] = date_format($creden['password'], 'd-m-Y');
        $creden['level_id'] = 1;

        if (Auth::attempt($creden)) {
            $req->session()->regenerate();
            return redirect()->intended('/siswa')->withErrors([
                'alerts' => ['success' => 'Login berhasil.']
            ]);
        }
        
        return back()->withErrors([
            'alerts' => ['error' => 'Login gagal.']
        ])->withInput($creden);
    }

    public function admindex()
    {
        return view('pages.login', [
            'variant' => 'admin',
            'page' => ['title' => 'Login Administrator PPDB'],
            'inputs' => [
                ['type' => 'text', 'name' => 'username', 'attr' => 'autofocus'],
                ['type' => 'password', 'name' => 'password'],
            ]
        ]);
    }

    public function admlogin(Request $req)
    {
        $creden = $req->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        
        if (Auth::attempt($creden)) {
            $req->session()->regenerate();
            return redirect()->intended('/admin')->withErrors([
                'alerts' => ['success' => 'Login berhasil.']
            ]);
        }
        
        return back()->withErrors([
            'alerts' => ['error' => 'Login gagal.']
        ])->withInput($creden);
    }

    public function logout()
    {
        try {
            
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();
            return redirect('/')->withErrors([
                'alerts' => ['success' => 'Logout berhasil.']
            ]);
            
        } catch (\Throwable $th) {
            return back()->withErrors([
                'alerts' => ['error' => 'Maaf, terjadi kesalahan saat mencoba logout.']
            ]);
        }
        
    }
    
}
