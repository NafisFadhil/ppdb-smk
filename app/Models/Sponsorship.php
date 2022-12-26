<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Casts\UppercaseCast;
use Illuminate\Database\Eloquent\Model;

class Sponsorship extends Model
{
    // use HasFactory;

    protected static $unguarded = true;
    protected $casts = [
        'nama' => UppercaseCast::class,
        'kelas' => UppercaseCast::class,
    ];

    public function identitas () {
        return $this->belongsTo(Identitas::class);
    }
}
