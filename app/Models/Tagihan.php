<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tagihan extends Model
{
    use HasFactory, SoftDeletes;

    protected static $unguarded = true;

    protected $casts = [
        'biaya_pendaftaran' => 'integer',
        'tagihan_pendaftaran' => 'integer',
        'admin_pendaftaran_id' => 'integer',
        'lunas_pendaftaran' => 'boolean',
        'tanggal_lunas_pendaftaran' => 'datetime',
        'biaya_daftar_ulang' => 'integer',
        'tagihan_daftar_ulang' => 'integer',
        'admin_daftar_ulang_id' => 'integer',
        'lunas_daftar_ulang' => 'boolean',
        'tanggal_lunas_daftar_ulang' => 'datetime',
        'biaya_seragam' => 'integer',
        'tagihan_seragam' => 'integer',
        'admin_seragam_id' => 'integer',
        'lunas_seragam' => 'boolean',
        'tanggal_lunas_seragam' => 'datetime',
        'identitas_id' => 'integer',
    ];

    public function identitas () {
        return $this->belongsTo(Identitas::class);
    }
    public function pembayarans () {
        return $this->hasMany(Pembayaran::class);
    }
    public function admin_pendaftaran () {
        return $this->belongsTo(User::class);
    }
    public function admin_daftar_ulang () {
        return $this->belongsTo(User::class);
    }
    public function admin_seragam () {
        return $this->belongsTo(User::class);
    }
    
}
