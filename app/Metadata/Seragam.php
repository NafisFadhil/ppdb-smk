<?php

namespace App\Metadata;

use App\Models\Seragam as ModelSeragam;

class Seragam
{
	
	public static $seragam = [
		[]
	];
	
	public static function getKode()
	{
		$kode = 'S';
		$model = ModelSeragam::select(['id'])->latest()->limit(1)->get()->first();
		if (!$model) return $kode.'-001';

		$nomor = $model->id + 1;
		$xnomor = str_pad($nomor, 3, '0', STR_PAD_LEFT);
		return $kode.'-'.$xnomor;
	}
	
}
