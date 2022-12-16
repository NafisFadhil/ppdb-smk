<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    // use HasFactory;

    protected static $unguarded = true;

    public function tagihan () {
        return $this->belongsTo(Tagihan::class);
    }

    public static function getBayar ($pembayarans, $type)
    {
        $bayar = 0;
        foreach ($pembayarans as $pembayaran) {
            if ($pembayaran['type'] === $type) $bayar += $pembayaran['bayar'];
        } return $bayar;
    }
    
}
