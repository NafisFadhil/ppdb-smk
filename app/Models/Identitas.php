<?php

namespace App\Models;

use App\Casts\UppercaseCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Identitas extends Model
{
    use HasFactory, SoftDeletes;
    
    protected static $unguarded = true;

    protected $casts = [
        'nama_lengkap' => UppercaseCast::class,
        'jenis_kelamin' => UppercaseCast::class,
        'asal_sekolah' => UppercaseCast::class,
        'nama_jurusan' => UppercaseCast::class,
        'tempat_lahir' => UppercaseCast::class,
        'alamat_desa' => UppercaseCast::class,
        'alamat_kec' => UppercaseCast::class,
        'alamat_kota_kab' => UppercaseCast::class,
        'nama_ayah' => UppercaseCast::class,
        'nama_ibu' => UppercaseCast::class,
        'tanggal_lahir' => 'datetime',
        'alamat_rt' => 'integer',
        'alamat_rw' => 'integer',
        'alamat_gg' => 'integer',
        'tahun_lahir_ayah' => 'integer',
        'tahun_lahir_ibu' => 'integer',
        'jumlah_saudara_kandung' => 'integer',
        'nik' => 'integer',
        'nisn' => 'integer',
        'no_ujian_nasional' => 'integer',
        'no_ijazah' => 'string',
        'buta_warna' => 'boolean',
        'jenis_kelamin_id' => 'integer',
        'jalur_pendaftaran_id' => 'integer',
        'status_id' => 'integer',
        'session_id' => 'integer',
    ];
    
    // Eloquent Relationship
    public function pendaftaran () {
        return $this->hasOne(Pendaftaran::class);
    }
    public function daftar_ulang () {
        return $this->hasOne(DaftarUlang::class);
    }
    public function seragam () {
        return $this->hasOne(Seragam::class);
    }
    public function tagihan () {
        return $this->hasOne(Tagihan::class);
    }
    public function verifikasi () {
        return $this->hasOne(Verifikasi::class);
    }
    public function user () {
        return $this->hasOne(User::class);
    }
    public function jurusan () {
        return $this->hasOne(Jurusan::class);
    }
    public function sponsorship () {
        return $this->hasOne(Sponsorship::class);
    }
    public function identitas () {
        return $this->hasManyThrough(Pembayaran::class, Tagihan::class);
    }
    public function jenis_kelamin () {
        return $this->belongsTo(DataJenisKelamin::class);
    }
    public function jalur_pendaftaran () {
        return $this->belongsTo(DataJalurPendaftaran::class);
    }
    public function status () {
        return $this->belongsTo(Status::class);
    }

    public static function getSubPrestasi (array $creden)
    {
        if ($creden['sub_jalur_pendaftaran_id'] && $creden['jalur_pendaftaran_id'] > 2) {
            $creden['jalur_pendaftaran_id'] = $creden['sub_jalur_pendaftaran_id'];
        }
        unset($creden['sub_jalur_pendaftaran_id']);
        return $creden;
    }

    public static function validateAge ($tanggal)
    {
        $datetime = new \DateTime($tanggal);
        $year = (int) $datetime->format('Y');
        $age = 2023 - $year;
        return $age <= 21 && $age >= 14 ? $tanggal : false;
    }
}
