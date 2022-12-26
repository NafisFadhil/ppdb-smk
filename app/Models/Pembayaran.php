<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pembayaran extends Model
{
    use HasFactory, SoftDeletes;

    protected static $unguarded = true;

    protected $casts = [
        'type' => 'string',
        'bayar' => 'integer',
        'kurang' => 'integer',
        'admin_id' => 'integer',
    ];

    public function tagihan () {
        return $this->belongsTo(Tagihan::class);
    }
    public function admin () {
        return $this->belongsTo(User::class);
    }

    public static function getBayar ($pembayarans, $type)
    {
        $bayar = 0;
        foreach ($pembayarans as $pembayaran) {
            if ($pembayaran['type'] === $type) $bayar += $pembayaran['bayar'];
        } return $bayar;
    }

}
