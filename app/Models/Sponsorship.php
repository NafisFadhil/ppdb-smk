<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsorship extends Model
{
    // use HasFactory;

    protected static $unguarded = true;

    public function identitas () {
        return $this->belongsTo(Identitas::class);
    }
}
