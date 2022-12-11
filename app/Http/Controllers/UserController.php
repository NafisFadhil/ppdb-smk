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

    protected $myvalidations = [
        'name',
        'username',
        'password',
        'avatar',
        'level_id',
    ];
    
    protected function getSearch ($model)
    {
        $search = request('search');
        return $model->where('username', 'like', "%$search%")
            ->orWhere('name', 'like', "%$search%");
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
        $model = User::whereNot('id', auth()->user()->id)
            ->whereNot('level_id', 1);
        if (request('search')) $model = $this->getSearch($model);
        $model = $model->with(['level'])->paginate();

        return view('admin.pages.users.index', [
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
        $model = User::where('level_id', 1);
        if (request('search')) $model = $this->getSearch($model);
        $model = $model->paginate();

        return view('admin.pages.users.index', [
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
        $creden = $req->validate(ModelHelper::getValidations($this->myvalidations, User::$validations));
        try {
            
            if ($req->hasFile('avatar')) $creden['avatar'] = ImageHelper::uploadAvatar($req->file('avatar'));
            
            $creden['password'] = Hash::make($creden['password']);
            $redir = '/admin/users/' . ($creden['level_id'] === 1 ? 'siswa' : 'admin');
            
            $user = User::create($creden);
            return redirect($redir)->withErrors([
                'alerts' => ['success' => 'Berhasil menambahkan user!']
            ]);
            
        } catch (\Throwable $th) {
            throw $th;
            return back()->withErrors([
                'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat menambahkan user!']
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
    public function update(Request $req, User $user, $profil = false)
    {

        $validations = ModelHelper::getValidations(
            $this->myvalidations,
            User::$validations
        );
        
        if (!$profil && $req->has('username') && $req->get('username') === $user->username) {
            $validations['username'] .= ',' . $user->id;
        }

        $creden = $req->validate($validations);

        try {
            
            if ($req->hasFile('avatar')) {
                if (!is_null($user->avatar) && !empty($user->avatar)) {
                    $paths = explode('/', $user->avatar);
                    $storagepath = implode('/', array_splice($paths, 2));
                    if ($paths[0] === 'storage') Storage::delete($storagepath);
                }

                $creden['avatar'] = ImageHelper::uploadAvatar($req->file('avatar'));
            }

            if (is_null($creden['password'])) unset($creden['password']);
            else $creden['password'] = Hash::make($creden['password']);

            $redir = '/admin/users/' . ($creden['level_id'] ?? $user->level_id === 1 ? 'siswa' : 'admin');
            $redir = $profil ? '/admin/profil' : $redir;
            
            $user = $user->update($creden);
            return redirect($redir)->withErrors([
                'alerts' => ['success' => 'Berhasil mengedit profil!']
            ]);
            
        } catch (\Throwable $th) {
            throw $th;
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
        //
    }

    public function xdestroy(User $user)
    {
        try {
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
