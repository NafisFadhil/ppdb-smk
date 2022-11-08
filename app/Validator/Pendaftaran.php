<?php

namespace App\Validator;

class Pendaftaran
{

	public static function validate ($req)
	{
		return $req->validate(self::regex());
	}

	public static function regex ()
	{
		return [
			'jalur_pendaftaran' => 'required|string',
			'nama_lengkap' => 'required|string',
			'tempat_lahir' => 'required|string',
			'tanggal_lahir' => 'required|string',
			'jenis_kelamin' => 'required|string',
			'alamat_rumah' => 'required|string',
			'nama_ayah' => 'required|string',
			'nama_ibu' => 'required|string',
			'jumlah_saudara_kandung' => 'required|numeric',
			'nik' => 'required|numeric|digits:16',
			'asal_sekolah' => 'required|string',
			'nisn' => 'required|numeric|digits:10',
			'no_ujian_nasional' => 'required|numeric',
			'no_ijazah' => 'required|numeric',
			'no_wa' => 'required|numeric|digits_between:10,14',
			'jurusan' => 'required|string',
		];
	}

}
