<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DaftarUlang extends Model
{
    use HasFactory, SoftDeletes;

    protected static $unguarded = true;
    protected $casts = [
        'keterangan' => 'string'
    ];

    public function identitas () {
        return $this->belongsTo(Identitas::class);
    }
    public function verifikasi () {
        return $this->hasOneThrough(Verifikasi::class, Identitas::class);
    }
    public function tagihan () {
        return $this->hasOneThrough(Tagihan::class, Identitas::class);
    }
    public function status () {
        return $this->hasOneThrough(Status::class, Identitas::class);
    }

}
