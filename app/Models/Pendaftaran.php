<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;
	// protected $fillable = [
	// 	'kode',
	// 	'identitas_id',
	// 	'biaya_pendaftaran',
	// 	'admin_biaya_pendaftaran',
	// 	'verifikasi_pendaftaran',
	// 	'admin_verifikasi_pendaftaran',
		
	// ];

    public function identitas () {
        return $this->belongsTo(Identitas::class);
    }

    public static function getKode()
	{
		$kode = 'P';
		$model = Pendaftaran::select(['id'])->latest()->limit(1)->get()->first();
		if (!$model) return $kode . '-001';

		$nomor = $model->id + 1;
		$xnomor = str_pad($nomor, 3, '0', STR_PAD_LEFT);
		return $kode.'-'.$xnomor;
	}

}
