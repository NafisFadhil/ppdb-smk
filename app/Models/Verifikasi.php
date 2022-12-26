<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Verifikasi extends Model
{
    use HasFactory, SoftDeletes;

    protected static $unguarded = true;
    protected $casts = [
        'identitas' => 'boolean',
        'tanggal_identitas' => 'datetime',
        'admin_identitas_id' => 'integer',
        'pendaftaran' => 'boolean',
        'tanggal_pendaftaran' => 'datetime',
        'admin_pendaftaran_id' => 'integer',
        'daftar_ulang' => 'boolean',
        'tanggal_daftar_ulang' => 'datetime',
        'admin_daftar_ulang_id' => 'integer',
        'seragam' => 'boolean',
        'tanggal_seragam' => 'datetime',
        'admin_seragam_id' => 'integer',
        'sponsorship' => 'boolean',
        'tanggal_sponsorship' => 'datetime',
        'admin_sponsorship_id' => 'integer',
    ];

    public function identitas() {
        return $this->belongsTo(Identitas::class);
    }
    public function admin_identitas() {
        return $this->belongsTo(User::class);
    }
    public function admin_pendaftaran() {
        return $this->belongsTo(User::class);
    }
    public function admin_daftar_ulang() {
        return $this->belongsTo(User::class);
    }
    public function admin_seragam() {
        return $this->belongsTo(User::class);
    }
    public function admin_sponsorship() {
        return $this->belongsTo(User::class);
    }
    
}
