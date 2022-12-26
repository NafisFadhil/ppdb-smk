<?php

namespace App\Validations;

class PembayaranValidation extends Validation
{
	
	public static function validations()
	{
		return [
			'type' => 'required|string',
			'bayar' => 'required|numeric',
			'kurang' => 'required|numeric',
			'admin_id' => 'required|numeric',
		];
	}
	
}
