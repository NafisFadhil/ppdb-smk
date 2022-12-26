<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Seragam extends Model
{
    use HasFactory, SoftDeletes;

    protected static $unguarded = true;
    protected $casts = [
        'ukuran_warepack' => 'string',
        'ukuran_almamater' => 'string',
        'ukuran_olahraga' => 'string',
        'keterangan' => 'string',
    ];

	public function identitas () {
        return $this->belongsTo(Identitas::class);
    }
	public function verifikasi () {
        return $this->hasOneThrough(Verifikasi::class, Identitas::class);
    }
    public function tagihan () {
        return $this->hasOneThrough(Tagihan::class, Identitas::class);
    }
    public function status () {
        return $this->hasOneThrough(Status::class, Identitas::class);
    }

    public static function getSeragams()
    {
        return Cache::rememberForever('seragams', fn() => DataSeragam::all());
    }

    public static function getOptions(string $type)
    {
        $seragams = static::getSeragams();
        $xtype = ucfirst($type);
        $opts = [['label' => "-- Pilih Ukuran $xtype --", 'value' => '']];
        foreach ($seragams as $row) {
            if ($row->seragam !== $type) continue;
            $ukuran = json_decode($row->ukuran, true);
            foreach ($ukuran as $ukr) {
                $opts[] = $ukr;
            }
        } return $opts;
    }

}
