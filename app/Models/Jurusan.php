<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
	use HasFactory;
	protected $fillable = ['kode','jurusan','slug','singkatan','nomor','identitas_id'];

	public function identitas () {
		return $this->belongsTo(Identitas::class);
	}
	
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
		'tkro' => 'R',
		'tbsm' => 'T',
		'tkj' => 'J',
		'akl' => 'A',
		'fkk' => 'F',
	];

	public static function getJurusan($value, $key = 'singkatan')
	{
		if ($key === 'id') return self::$jurusan[$value];
		else {
			foreach (self::$jurusan as $item) {
				if ($item[$key] === $value) return $item;
			}
		}
	}

	public static function getKode(string $singkatan, int $nomor = null)
	{
		$jurusan = self::getJurusan($singkatan, 'singkatan');

		if (!array_key_exists($jurusan['singkatan'], self::$kode)) return false;
		
		if (!$nomor) {
			$model = Jurusan::where('singkatan', $jurusan['singkatan'])
				->latest()->limit(1)->get()->first();

			if (!$model) {
				self::$nomor = 1;
				return self::$kode[$jurusan['singkatan']] . '-001';
			}
			self::$nomor = $nomor = $model->nomor + 1;
		}

		$kode = self::$kode[$jurusan['singkatan']];
		$xnomor = str_pad($nomor, 3, '0', STR_PAD_LEFT);
		return $kode . '-' . $xnomor;
	}

	public static function getOptions()
	{
		$jurusan = self::$jurusan;
		$new_jurusan = [['value' => '', 'label' => '--Pilih Jurusan--']];
		for ($i = 0; $i < count($jurusan); $i++) {
			$new_jurusan[] = [
				'label' => $jurusan[$i]['nama'], 'value' => $jurusan[$i]['singkatan']
			];
		}
		return $new_jurusan;
	}
	
	public static function new(string $singkatan)
	{
		$jurusan = self::getJurusan($singkatan, 'singkatan');
		return [
			'kode' => self::getKode($singkatan),
			'jurusan' => $jurusan['nama'],
			'slug' => $jurusan['slug'],
			'singkatan' => $jurusan['singkatan'],
			'nomor' => self::$nomor
		];
	}

}
