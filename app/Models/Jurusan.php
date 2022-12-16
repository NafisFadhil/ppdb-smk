<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
	// use HasFactory;
	// protected $fillable = ['kode','jurusan','slug','singkatan','nomor','identitas_id'];

	protected static $unguarded = true;

	public function identitas () {
		return $this->belongsTo(Identitas::class);
	}
	
	public static $nomor;

	public static $jurusan = [];

	public static $kode = [];

	public static function initJurusan() :void
	{
		if (empty(self::$jurusan)) {
			self::$jurusan = DataJurusan::all()->toArray();
		}
	}

	public static function initKode() :void
	{
		if (empty(self::$jurusan)) self::initJurusan();
		if (empty(self::$kode)) {
			$kode = [];
			foreach (self::$jurusan as $jurusan) {
				$kode[ $jurusan['singkatan'] ] = $jurusan['kode'];
			} self::$kode = $kode;
		}
	}
	
	public static function getJurusan($value, $key = 'singkatan')
	{
		self::initJurusan();
		if ($key === 'id') return self::$jurusan[$value];
		else {
			$value = strtolower($value);
			foreach (self::$jurusan as $item) {
				if ($item[$key] === $value) return $item;
			}
		}
	}

	public static function getKode(string $singkatan, int $nomor = null)
	{
		$singkatan = strtolower($singkatan);
		$jurusan = self::getJurusan($singkatan, 'singkatan');

		self::initKode();
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

	public static function getWidget() :array
	{
		self::initJurusan();
		$counters = [
			'tbsm' => 0,
			'tkro' => 0,
			'tkj' => 0,
			'akl' => 0,
			'fkk' => 0,
		];
		foreach (self::$jurusan as $jurusan) {
			$counters = array_replace($counters, [
				$jurusan['singkatan'] => 0
			]);
		} return $counters;
	}

	public static function getOptions()
	{
		self::initJurusan();
		$jurusan = self::$jurusan;
		$new_jurusan = [['value' => '', 'label' => '--Pilih Jurusan--']];
		for ($i = 0; $i < count($jurusan); $i++) {
			$new_jurusan[] = [
				'label' => strtoupper($jurusan[$i]['nama']),
				'value' => strtoupper($jurusan[$i]['singkatan'])
			];
		}
		return $new_jurusan;
	}
	
	public static function new(string $singkatan)
	{
		self::initJurusan();
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
