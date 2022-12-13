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
        'ukuran_seragam' => 'nullable|string'
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

    public static function getValidations(array $names)
    {
        $result = [];
        foreach ($names as $key) {
            $result[$key] = self::$validations[$key] ?? '';
        }
        return $result;
    }

}
