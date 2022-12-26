<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class DataJenisKelamin extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected static $unguarded = true;

    public static function getJenisKelamins () {
        return Cache::rememberForever('jenis_kelamins', fn() => DataJenisKelamin::all());
    }

    public static function getJenisKelamin (int $id) {
        $jenis_kelamins = static::getJenisKelamins();
        return $jenis_kelamins[$id-1]['label'];
    }
    
    public static function getOptions ()
    {
        $jenis_kelamins = static::getJenisKelamins();
        $opts = [];
        foreach ($jenis_kelamins as $row) {
            $opts[] = [
                'label' => $row->label,
                'value' => $row->id,
            ];
        } return $opts;
    }
    
}
