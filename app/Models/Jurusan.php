<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    public static $nomor;
	
	public static $jurusan = [
		[
			"nama" => "Teknik Kendaraan Ringan Otomotif",
			"slug" => "teknik-kendaraan-ringan-otomotif",
			"singkatan" => 'tkro',
			'kode' => 'R'
		],
		[
			"nama" => "Teknik Bisnis dan Sepeda Motor",
			"slug" => "teknik-bisnis-dan-sepeda motor",
			"singkatan" => 'tbsm',
			'kode' => 'T'
		],
		[
			"nama" => "Teknik Komputer dan Jaringan",
			"slug" => "teknik-komputer-dan-jaringan",
			"singkatan" => 'tkj',
			'kode' => 'J'
		],
		[
			"nama" => "Akuntansi dan Keuangan Lembaga",
			"slug" => "akuntansi-dan-keuangan-lembaga",
			"singkatan" => 'akl',
			'kode' => 'A'
		],
		[
			"nama" => "Farmasi Klinis dan Kesehatan",
			"slug" => "farmasi-klinis-dan-kesehatan",
			"singkatan" => 'fkk',
			'kode' => 'F'
		],
	];

	public static $kode = [
		'teknik-kendaraan-ringan-otomotif' => 'R',
		'teknik-bisnis-dan-sepeda motor' => 'T',
		'teknik-komputer-dan-jaringan' => 'J',
		'akuntansi-dan-keuangan-lembaga' => 'A',
		'farmasi-klinis-dan-kesehatan' => 'F',
	];

	public static function getKode (string $jurusan, int $nomor = null)
	{
		if (!array_key_exists($jurusan, self::$kode)) return false;
		if (!$nomor) {
			$model = Jurusan::where('jurusan', $jurusan)->latest()->limit(1)->get()->first();
			if (!$model) {
				self::$nomor = 1;
				return self::$kode[$jurusan].'-001';
			}
			self::$nomor = $nomor = $model->nomor + 1;
		}
		$kode = self::$kode[$jurusan];
		$xnomor = str_pad($nomor, 3, '0', STR_PAD_LEFT);
		return $kode.'-'.$xnomor;
	}
}
