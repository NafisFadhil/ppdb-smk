<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JalurPendaftaran extends Model
{
    // use HasFactory;

    public $timestamps = false;
    
    public function identitases () {
        return $this->hasMany(Identitas::class);
    }
    
}
