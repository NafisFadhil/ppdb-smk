<?php

namespace App\Models;

use App\Casts\UppercaseCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected static $unguarded = true;
    protected $casts = [
        'name' => 'string',
        'username' => 'string',
        'password' => 'string',
    ];

    public function identitas () {
        return $this->belongsTo(Identitas::class);
    }
    public function level () {
        return $this->belongsTo(UserLevel::class);
    }

}
