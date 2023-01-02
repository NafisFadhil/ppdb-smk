<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Helpers\ModelHelper;
use App\Models\User;
use App\Models\UserLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    protected function getValidations (string $type, Request $req, User $user = null)
    {
        if ($type === 'store') return [
            'name' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|min:8',
            'avatar' => 'nullable|image',
            'level_id' => 'required|numeric'
        ]; elseif ($type === 'update') return [
            'name' => 'required|string',
            'username' => 'required|string|unique:users,username,'.$user->id,
            'password' => 'nullable|string|min:8',
            'avatar' => 'nullable|image',
            'level_id' => 'required|numeric'
        ];
    }
    
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
        $search = request('search');
        $model = User::where([
            ['username', 'like', "%$search%",],
            ['name', 'like', "%$search%"],
            ['id', '!=', auth()->user()->id],
            ['level_id', '!=', 1]
        ])->with(['level'])->paginate();
        // array_splice(,)
        
        return view('admin.pages.users', [
            'bigtype' => 'admin',
            'page' => ['title' => 'Kelola User Admin'],
            'users' => $model
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function siswa()
    {
        $search = request('search');
        $model = User::where([
            ['username', 'like', "%$search%",],
            ['name', 'like', "%$search%"],
            ['level_id', 1]
        ])->with(['level'])->paginate();

        return view('admin.pages.users', [
            'bigtype' => 'siswa',
            'page' => ['title' => 'Kelola User Siswa'],
            'users' => $model
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.forms', [
            'page' => ['title' => 'Tambah User'],
            'form' => [
                'action' => '/admin/users',
                'enctype' => 'multipart/form-data',
                'button' => [
                    'variant' => 'primary',
                    'content' => '<i class="fa fa-plus"></i> Tambahkan'
                ],
                'inputs' => [
                    ['type' => 'avatar', 'name' => 'avatar', 'value' => '/dist/img/avatar5.png'],
                    ['type' => 'file', 'name' => 'avatar', 'placeholder' => 'Upload Avatar', 'value' => old('avatar')],
                    ['type' => 'text', 'name' => 'name', 'label' => 'Nama Admin'],
                    ['type' => 'text', 'name' => 'username'],
                    ['type' => 'password', 'name' => 'password'],
                    ['type' => 'select', 'name' => 'level_id', 'label' => 'User Level', 'options' => UserLevel::getOptions()],
                ]
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        $creden = $req->validate($this->getValidations('store', $req));

        try {
            
            if ($req->hasFile('avatar')) {
                $creden['avatar'] = ImageHelper::uploadAvatar($req->file('avatar'));
            }

            $creden['password'] = Hash::make($creden['password']);
            $redir = '/admin/users/' . ($creden['level_id'] === 1 ? 'siswa' : 'admin');
            $user = User::create($creden);

            return redirect($redir)->withErrors([
                'alerts' => ['success' => 'Berhasil mengedit profil!']
            ]);
            
        } catch (\Throwable $th) {
            return back()->withErrors([
                'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat mengedit profil!']
            ])->withInput($creden);
        }
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
                'enctype' => 'multipart/form-data',
                'button' => [
                    'variant' => 'warning',
                    'content' => '<i class="fa fa-pen"></i> Edit'
                ],
                'inputs' => [
                    ['type' => 'avatar', 'name' => 'avatar', 'value' => $user->avatar],
                    ['type' => 'file', 'name' => 'avatar', 'placeholder' => 'Upload Avatar'],
                    ['type' => 'text', 'name' => 'name', 'label' => 'Nama Admin', 'value' => $user->name],
                    ['type' => 'text', 'name' => 'username', 'value' => $user->username],
                    ['type' => 'password', 'name' => 'password', 'label' => 'Password Baru', 'placeholder' => '(Opsional)'],
                    ['type' => 'select', 'name' => 'level_id', 'label' => 'User Level', 'value' => $user->level_id, 'options' => UserLevel::getOptions()],
                ]
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $req
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, User $user)
    {

        $creden = $req->validate($this->getValidations('update', $req, $user));

        try {
            
            if ($req->hasFile('avatar')) {
                if (!is_null($user->avatar) && !empty($user->avatar)) {
                    $paths = explode('/', $user->avatar);
                    $storagepath = implode('/', array_slice($paths, 2));
                    if ($paths[1] === 'storage') Storage::delete($storagepath);
                }

                $creden['avatar'] = ImageHelper::uploadAvatar($req->file('avatar'));
            }

            if (is_null($creden['password'])) unset($creden['password']);
            else $creden['password'] = Hash::make($creden['password']);

            $redir = '/admin/users/' . ($creden['level_id'] === 1 ? 'siswa' : 'admin');
            
            $user = $user->update($creden);
            return redirect($redir)->withErrors([
                'alerts' => ['success' => 'Berhasil mengedit profil!']
            ]);
            
        } catch (\Throwable $th) {
            return back()->withErrors([
                'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat mengedit profil!']
            ])->withInput($creden);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            if (!is_null($user->avatar) && !empty($user->avatar)) {
                $paths = explode('/', $user->avatar);
                $storagepath = implode('/', array_slice($paths, 2));
                if ($paths[1] === 'storage') Storage::delete($storagepath);
            }
            
            $user->delete();
            return back()->withErrors([
                'alerts' => ['success' => 'Berhasil menghapus user!']
            ]);
        } catch (\Throwable $th) {
            return back()->withErrors([
                'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat menghapus user!']
            ]);
        }
    }
    
}
