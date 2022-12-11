<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLevel extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function users () {
        return $this->hasMany(User::class);
    }

    public static function getOptions ()
    {
        $levels = UserLevel::all();
        $opts = [];
        foreach ($levels as $level) {
            $opts[] = [
                'label' => $level->name,
                'value' => $level->id
            ];
        } return $opts;
    }
}
