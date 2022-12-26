<?php

namespace App\Validations;

class PendaftaranValidation extends Validation
{

	public static function validations ()
	{
		return [
			'kode' => 'required|string',
			'keterangan' => 'nullable|string',
		];
	}
	
}
