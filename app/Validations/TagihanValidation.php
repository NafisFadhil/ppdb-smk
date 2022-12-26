<?php

namespace App\Validations;

class TagihanValidation extends Validation
{

	public static function validations ()
	{
		return [
			'id' => 'required|numeric',
			'biaya_pendaftaran' => 'required|numeric',
			'tagihan_pendaftaran' => 'required|numeric',
			'admin_pendaftaran_id' => 'required|numeric',
			'lunas_pendaftaran' => 'required|numeric',
			'tanggal_lunas_pendaftaran' => 'required|numeric',
			'biaya_daftar_ulang' => 'required|numeric',
			'tagihan_daftar_ulang' => 'required|numeric',
			'admin_daftar_ulang_id' => 'required|numeric',
			'lunas_daftar_ulang' => 'required|numeric',
			'tanggal_lunas_daftar_ulang' => 'required|numeric',
			'biaya_seragam' => 'required|numeric',
			'tagihan_seragam' => 'required|numeric',
			'admin_seragam_id' => 'required|numeric',
			'lunas_seragam' => 'required|numeric',
			'tanggal_lunas_seragam' => 'required|numeric',
			'identitas_id' => 'required|numeric',
		];
	}
	
}
