<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Identitas extends Model
{
    use HasFactory;
    protected $fillable = [
        'jalur_pendaftaran',
        'nama_lengkap',
        'tanggal_lahir',
        'jenis_kelamin',
        'asal_sekolah',
        'no_wa_ortu',
        'no_wa_siswa',
        'nama_jurusan',
        'status_id'
    ];
    
    public function pendaftaran () {
        return $this->hasOne(Pendaftaran::class);
    }
    public function daftar_ulang () {
        return $this->hasOne(DaftarUlang::class);
    }
    public function seragam () {
        return $this->hasOne(Seragam::class);
    }
    public function user () {
        return $this->hasOne(User::class);
    }
    public function sponsorship () {
        return $this->hasOne(Sponsorship::class);
    }
    public function jurusan () {
        return $this->hasOne(Jurusan::class);
    }
    public function status () {
        return $this->belongsTo(Status::class);
    }

    public static $validations = [
        'jalur_pendaftaran' => 'required|string',
        'nama_lengkap' => 'required|string',
        'tanggal_lahir' => 'required|date',
        'jenis_kelamin' => 'required|string',
        'asal_sekolah' => 'required|string',
        'no_wa_ortu' => 'required|numeric|digits_between:10,14',
        'no_wa_siswa' => 'required|numeric|digits_between:10,14',
        'nama_jurusan' => 'required|string',
    ];

    public static function getValidations(array $names)
    {
        $result = [];
        foreach ($names as $key) {
            $result[$key] = self::$validations[$key] ?? '';
        }
        return $result;
    }
}
