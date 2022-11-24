<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLevel extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function users () {
        return $this->hasMany(User::class);
    }

    public static $level = [
        // Level Peserta PPDB
        // ['id' => 1, 'name' => 'pendaftar', 'desc' => 'Peserta PPDB sudah melakukan pendaftaran.'],
        // ['id' => 2, 'name' => 'daftar-ulang', 'desc' => 'Peserta PPDB sudah melakukan daftar ulang.'],
        // ['id' => 3, 'name' => 'seragam', 'desc' => 'Peserta PPDB sudah melunasi biaya seragam.'],
        ['id' => 1, 'name' => 'siswa', 'desc' => 'Siswa peserta PPDB.'],
        // Level Administrator
        ['id' => 2, 'name' => 'admin-pendaftaran', 'desc' => 'Panitia PPDB bagian pendaftaran.'],
        ['id' => 3, 'name' => 'admin-daftar-ulang', 'desc' => 'Panitia PPDB bagian daftar ulang.'],
        ['id' => 4, 'name' => 'admin-seragam', 'desc' => 'Panitia PPDB bagian seragam.'],
        ['id' => 5, 'name' => 'super-admin', 'desc' => 'Top Level Privilege'],
    ];
    
}
