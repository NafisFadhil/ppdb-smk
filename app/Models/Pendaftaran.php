<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    public $timestamps = false;

    public static function get_kode($id)
    {
        $prefix = 'P-'; $count = strlen($id);
        $kode = $prefix . ($count === 3 ? $id : ($count === 2 ? '0'.$id : '00'.$id) );
        return $kode;
    }

    public function identitas()
    {
        return $this->belongsTo(Identitas::class);
    }
    
}
