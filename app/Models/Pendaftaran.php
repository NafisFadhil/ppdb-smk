<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    public function identitas ()
    {
        return $this->belongsTo(Identitas::class);
    }

    public function pembayaran ()
    {
        return $this->belongsTo(Pembayaran::class);
    }

    public function jurusan ()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function seragam ()
    {
        return $this->belongsTo(Seragam::class);
    }

    public function user ()
    {
        return $this->belongsTo(User::class);
    }

    public function level ()
    {
        return $this->belongsTo(UserLevel::class);
    }

    public static function getKode()
	{
		$kode = 'P';
		$model = Pendaftaran::select(['id'])->latest()->limit(1)->get()->first();
		if (!$model) return $kode.'-001';

		$nomor = $model->id + 1;
		$xnomor = str_pad($nomor, 3, '0', STR_PAD_LEFT);
		return $kode.'-'.$xnomor;
	}

}
