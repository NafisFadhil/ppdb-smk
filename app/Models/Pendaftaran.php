<?php

namespace App\Models;

use App\Casts\UppercaseCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pendaftaran extends Model
{
    use HasFactory, SoftDeletes;

	protected static $unguarded = true;
    private static string $kode = 'p';
    protected $casts = [
        'kode' => UppercaseCast::class,
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

    public static function getKode($id = null) {
		$kode = static::$kode;

        if (is_null($id)) {
            $model = Pendaftaran::select(['id'])->orderBy('id', 'DESC')
                ->whereNull('deleted_at')->limit(1)->get()->first();
            if (!$model) return $kode . '-001';
            $nomor = $model->id + 1;
        } else $nomor = $id;
        
		$xnomor = str_pad($nomor, 3, '0', STR_PAD_LEFT);
		return $kode.'-'.$xnomor;
	}

}
