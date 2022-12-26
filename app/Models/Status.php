<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Status extends Model
{
    use HasFactory;

    public function identitas () {
        return $this->hasMany(Identitas::class);
    }

    public static function getStatuses ()
    {
        return Cache::rememberForever('statuses', Status::all());
    }

    public static function getStatus(mixed $value, string $key = 'id')
    {
        $statuses = static::getStatuses();
        foreach ($statuses as $status) {
            if ($status[$key] == $value) return $status;
        }
    }
}
