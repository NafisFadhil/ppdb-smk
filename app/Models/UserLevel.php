<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class UserLevel extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function users () {
        return $this->hasMany(User::class);
    }

    public static function getOptions ()
    {
        $levels = Cache::rememberForever('user_levels', fn() => UserLevel::all());
        $opts = [];
        foreach ($levels as $level) {
            $opts[] = [
                'label' => $level->level,
                'value' => $level->id
            ];
        } return $opts;
    }
}
