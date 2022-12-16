<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Identitas extends Model
{
    protected static $unguarded = true;
    
    // Accessor and Mutators
    private function uppercaseAttribute() :Attribute {
        return Attribute::make(
            get: fn ($value) => strtoupper($value),
            set: fn ($value) => strtoupper($value),
        );
    }
    protected function namaLengkap() :Attribute {
        return $this->uppercaseAttribute();
    } 
    protected function jenisKelamin() :Attribute {
        return $this->uppercaseAttribute();
    } 
    protected function asalSekolah() :Attribute {
        return $this->uppercaseAttribute();
    } 
    protected function namaJurusan() :Attribute {
        return $this->uppercaseAttribute();
    } 
    protected function tempatLahir() :Attribute {
        return $this->uppercaseAttribute();
    } 
    protected function alamatDesa() :Attribute {
        return $this->uppercaseAttribute();
    } 
    protected function alamatKec() :Attribute {
        return $this->uppercaseAttribute();
    } 
    protected function alamatKotaKab() :Attribute {
        return $this->uppercaseAttribute();
    } 
    protected function namaAyah() :Attribute {
        return $this->uppercaseAttribute();
    } 
    protected function namaIbu() :Attribute {
        return $this->uppercaseAttribute();
    } 
    
    // Eloquent Relationship
    public function pendaftaran () {
        return $this->hasOne(Pendaftaran::class);
    }
    public function duseragam () {
        return $this->hasOne(DUSeragam::class);
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
    public function tagihan () {
        return $this->hasOne(Tagihan::class);
    }
    public function jalur_pendaftaran () {
        return $this->belongsTo(JalurPendaftaran::class);
    }
    public function status () {
        return $this->belongsTo(Status::class);
    }

    public static $validations = [
        'jalur_pendaftaran_id' => 'required|numeric',
        'sub_jalur_pendaftaran_id' => 'nullable|required_if:jalur_pendaftaran_id,3|numeric',
        'nama_lengkap' => 'required|string',
        'tanggal_lahir' => 'required|date',
        'jenis_kelamin' => 'required|string',
        'asal_sekolah' => 'required|string',
        'no_wa_siswa' => 'required|numeric|digits_between:10,14',
        'nama_jurusan' => 'required|string',
        // Advanced Form Inputs
        'no_wa_ortu' => 'nullable|numeric|digits_between:10,14',
        'tempat_lahir' => 'nullable|string',
        'alamat_desa' => 'nullable|string',
        'alamat_kec' => 'nullable|string',
        'alamat_kota_kab' => 'nullable|string',
        'alamat_rt' => 'nullable|numeric',
        'alamat_rw' => 'nullable|numeric',
        'nama_ayah' => 'nullable|string',
        'nama_ibu' => 'nullable|string',
        'jumlah_saudara_kandung' => 'nullable|numeric',
        'nik' => 'nullable|numeric|digits:16',
        'nisn' => 'nullable|numeric|digits:10',
        'no_ujian_nasional' => 'nullable|numeric',
        'no_ijazah' => 'nullable|numeric',
    ];

    public static function getValidations(array $names)
    {
        $result = [];
        foreach ($names as $key) {
            $result[$key] = self::$validations[$key] ?? '';
        }
        return $result;
    }

    public static function getSubPrestasi (array $creden)
    {
        if ($creden['sub_jalur_pendaftaran_id']) {
            $creden['jalur_pendaftaran_id'] = $creden['sub_jalur_pendaftaran_id'];
        }
        unset($creden['sub_jalur_pendaftaran_id']);
        return $creden;
    }

    public static function validateAge ($tanggal)
    {
        $datetime = new DateTime($tanggal);
        $year = (int) $datetime->format('Y');
        $age = 2023 - $year;
        return $age <= 21 && $age >= 14 ? $tanggal : false;
    }
}
