<?php

namespace App\Validations;

class SeragamValidation extends Validation
{
	
	public static function validations ()
	{
		return [
			'ukuran_olahraga' => 'nullable|string',
			'ukuran_wearpack' => 'nullable|string',
			'ukuran_almamater' => 'nullable|string',
		];
	}
	
}
