<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Casts\UppercaseCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Jurusan extends Model
{
	use SoftDeletes;

	protected static $unguarded = true;
	public static $nomor;

	protected $casts = [
		'nama' => UppercaseCast::class,
		'singkatan' => UppercaseCast::class,
		'kode' => UppercaseCast::class,
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
	
	public static function getJurusans()
	{
		return Cache::rememberForever('jurusans', fn() => DataJurusan::all());
	}

	public static function getJurusan($value, $key = 'singkatan') 
	{
		$data_jurusans = static::getJurusans();
		foreach ($data_jurusans as $jurusan) {
			if ($jurusan->$key == $value) return $jurusan;
		}
	}

	public static function getKode(string $singkatan, int $nomor = null)
	{
		$jurusan = static::getJurusan(strtolower($singkatan));
		$kode = $jurusan->kode;

        $model = Jurusan::withTrashed()->select('nomor')->whereNotNull('nomor')
		->where('singkatan', $singkatan)->orderBy('nomor', 'DESC')->limit(1)->get()->first();

        if (!$model) {
			$nomor = 1;
		} else $nomor = $model->nomor + 1;

		static::$nomor = $nomor;
        
		$xnomor = str_pad($nomor, 3, '0', STR_PAD_LEFT);
		return $kode.'-'.$xnomor;
	}

	public static function getNomor(string|null $kode = null)
	{
		if (is_null($kode)) return static::$nomor ?? 0;
		return intval(substr($kode, 2));
	}

	public static function getOptions()
	{
		$jurusan = static::getJurusans();
		$opts = [['value' => '', 'label' => '-- Pilih Jurusan --']];
		for ($i = 0; $i < count($jurusan); $i++) {
			$opts[] = [
				'label' => strtoupper($jurusan[$i]['nama'] . ' ('. $jurusan[$i]['singkatan'] .')'),
				'value' => $jurusan[$i]['singkatan']
			];
		}
		return $opts;
	}
	
	// public static function getWidget(array $peserta) :array
	// {
	// 	$counters = [
	// 		'tsm' => 0,
	// 		'tkr' => 0,
	// 		'tkj' => 0,
	// 		'akuntansi' => 0,
	// 		'fkk' => 0,
	// 	];
	// 	foreach (static::$jurusan as $jurusan) {
	// 		$counters = array_replace($counters, [
	// 			$jurusan['singkatan'] => 0
	// 		]);
	// 	}
	// 	foreach ($peserta as $row) $counters[strtolower($row['nama_jurusan'])]++;
	// 	return $counters;
	// }
	
	// public static function new(string $singkatan)
	// {
	// 	$jurusan = static::getJurusan($singkatan, 'singkatan');
	// 	return [
	// 		'kode' => static::getKode($singkatan),
	// 		'jurusan' => $jurusan['nama'],
	// 		'slug' => $jurusan['slug'],
	// 		'singkatan' => $jurusan['singkatan'],
	// 		'nomor' => static::$nomor
	// 	];
	// }

}
