<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserProfilController extends Controller
{

    protected $baseform = [
        'action' => '/admin/profil',
        'submethod' => 'PUT',
        'enctype' => 'multipart/form-data',
        'button' => [
            'variant' => 'warning',
            'content' => '<i class="fa fa-pen"></i> Edit'
        ],
        'inputs' => []
    ];

    protected function getForm (array $inputs) :array
    {
        return array_replace_recursive($this->baseform, [
            'inputs' => $inputs
        ]);
    }

    protected function getInputs (User $user) :array
    {
        if ($user->level->name === 'super-admin') return [
            ['type' => 'avatar', 'name' => 'avatar', 'value' => $user->avatar],
            ['type' => 'file', 'name' => 'avatar', 'placeholder' => 'Upload Avatar'],
            ['type' => 'text', 'name' => 'name', 'label' => 'Nama Admin', 'value' => $user->name],
            ['type' => 'text', 'name' => 'username', 'value' => $user->username],
            ['type' => 'password', 'name' => 'password', 'label' => 'Password Baru', 'placeholder' => '(Opsional)'],
        ]; else return [
            ['type' => 'avatar', 'name' => 'avatar', 'value' => $user->avatar],
            ['type' => 'file', 'name' => 'avatar', 'placeholder' => 'Upload Avatar'],
            ['type' => 'text', 'name' => 'name', 'label' => 'Nama Admin', 'value' => $user->name, 'attr' => 'disabled'],
            ['type' => 'text', 'name' => 'username', 'value' => $user->username, 'attr' => 'disabled'],
            ['type' => 'password', 'name' => 'password', 'label' => 'Password Baru', 'placeholder' => '(Opsional)'],
        ];
    }

    protected function getValidation (User $user) :array
    {
        if ($user->level->name === 'super-admin') return [
            'name' => 'nullable|string',
            'username' => 'required|string|unique:users,username,'.$user->id,
            'password' => 'nullable|string|min:8',
            'avatar' => 'nullable|image',
        ]; else return [
            'password' => 'nullable|string|min:8',
            'avatar' => 'nullable|image',
        ];
    }

    public function profil ()
    {
        $user = auth()->user();

        return view('admin.pages.forms', [
            'page' => ['title' => 'Edit Profil'],
            'form' => $this->getForm($this->getInputs($user))
        ]);
    }

    public function update (Request $req)
    {

        $user = $req->user();        
        $validations = $this->getValidation($user);        
        $creden = $req->validate($validations);

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

            $user->update($creden);

            return redirect('/admin/profil')->withErrors([
                'alerts' => ['success' => 'Berhasil mengedit profil!']
            ]);
            
        } catch (\Throwable $th) {
            return back()->withErrors([
                'alerts' => ['danger' => 'Maaf, terjadi kesalahan saat mengedit profil!']
            ])->withInput($creden);
        }
    }
    
}
