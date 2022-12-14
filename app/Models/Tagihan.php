<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    // use HasFactory;

    protected static $unguarded = true;

    public function identitas () {
        return $this->belongsTo(Identitas::class);
    }
    public function pembayarans () {
        return $this->hasMany(Pembayaran::class);
    }
    
}
