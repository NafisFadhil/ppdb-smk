<?php

namespace App\Validations;

class JurusanValidation extends Validation
{

	public static function validations ()
	{
		return [
			'kode' => 'required|string',
			'nama' => 'required|string',
			'slug' => 'required|string',
			'singkatan' => 'required|string',
			'nomor' => 'required|numeric',
		];
	}
	
}
