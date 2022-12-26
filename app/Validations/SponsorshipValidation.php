<?php

namespace App\Validations;

class SponsorshipValidation extends Validation
{
	
	public static function validations ()
	{
		return [
			'nama' => 'required|string',
			'kelas' => 'required|string',
			'no_wa' => 'required|numeric',
		];
	}
	
}
