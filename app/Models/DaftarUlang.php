<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarUlang extends Model
{
    use HasFactory;
    protected $fillable = ["pembayaran","angsuran","lunas","identitas_id"];

    public function identitas () {
        return $this->belongsTo(Identitas::class);
    }

    public static $validations = [
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
        'no_ijazah' => 'nullable|string',
    ];
    // public static $validations = [
    //     'tempat_lahir' => 'required|string',
    //     'alamat_desa' => 'required|string',
    //     'alamat_kec' => 'required|string',
    //     'alamat_kota_kab' => 'required|string',
    //     'alamat_rt' => 'required|numeric',
    //     'alamat_rw' => 'required|numeric',
    //     'nama_ayah' => 'required|string',
    //     'nama_ibu' => 'required|string',
    //     'jumlah_saudara_kandung' => 'required|numeric',
    //     'nik' => 'required|numeric|digits:16',
    //     'nisn' => 'required|numeric|digits:10',
    //     'no_ujian_nasional' => 'required|numeric',
    //     'no_ijazah' => 'required|string',
    // ];
}
