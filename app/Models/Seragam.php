<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seragam extends Model
{
    use HasFactory;

	public function identitas () {
        return $this->belongsTo(Identitas::class);
    }

	public static $seragam = [
		[]
	];
	
	public static function getKode()
	{
		$kode = 'S';
		$model = Seragam::select(['id'])->latest()->limit(1)->get()->first();
		if (!$model) return $kode.'-001';

		$nomor = $model->id + 1;
		$xnomor = str_pad($nomor, 3, '0', STR_PAD_LEFT);
		return $kode.'-'.$xnomor;
	}

}
