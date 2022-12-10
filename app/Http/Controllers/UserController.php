<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    protected $admvalidations = [
        // 'avatar' => 'nullable|file',
        'password' => 'nullable|string|min:8'
    ];

    public function admprofil()
    {
        return view('admin.pages.profil', [
            'page' => ['title' => 'User Profil']
        ]);
    }

    public function postAdmprofil(Request $req)
    {
        $creden = $req->validate($this->admvalidations);

        try {

            // if ($creden['avatar']) {
            //     dd($req->file('avatar'));
            // }
            
            if ($creden['password']) $creden['password'] = Hash::make($creden['password']);
            else unset($creden['password']);
            
            $user = $req->user()->update($creden);

            return redirect('/admin')->withErrors([
                'alerts' => ['success' => 'Profil berhasil diubah.']
            ]);

        } catch (\Throwable $th) {
            throw $th;
            return redirect('/admin/profil')->withErrors([
                'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat mengubah profil.']
            ]);
        }
    }
    
}
