<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect('/admin')->withErrors([
            'alerts' => ['warning' => 'Maaf, halaman tidak tersedia!']
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin()
    {
        return view('admin.pages.users.index', [
            'page' => ['title' => 'Kelola User Admin'],
            'users' => User::whereNot('id', auth()->user()->id)
                ->whereNot('level_id', 1)->with(['level'])->paginate()
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function siswa()
    {
        return view('admin.pages.users.index', [
            'page' => ['title' => 'Kelola User Siswa'],
            'users' => User::where('level_id', 1)->paginate()
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.pages.forms', [
            'page' => ['title' => 'Edit User'],
            'form' => [
                'action' => '/admin/users/'.$user->id,
                'submethod' => 'PUT',
                'button' => [
                    'variant' => ''
                ]
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

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

    public function xprofil(Request $req)
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
