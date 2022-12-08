<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DUSeragam extends Model
{
    // use HasFactory;

    protected $table = 'duseragams';

    public function identitas () {
        return $this->belongsTo(Identitas::class);
    }

    public static $validations = [
        'tempat_lahir',
        'alamat_desa',
        'alamat_kec',
        'alamat_kota_kab',
        'alamat_rt',
        'alamat_rw',
        'nama_ayah',
        'nama_ibu',
        'jumlah_saudara_kandung',
        'nik',
        'nisn',
        'no_ujian_nasional',
        'no_ijazah',
    ];

    public static function getKode()
	{
		$kode = 'DUS';
		$model = DUSeragam::select(['id'])->latest()->limit(1)->get()->first();
		if (!$model) return $kode.'-001';

		$nomor = $model->id + 1;
		$xnomor = str_pad($nomor, 3, '0', STR_PAD_LEFT);
		return $kode.'-'.$xnomor;
	}

}
