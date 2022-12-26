<?php

namespace App\Validations;

class UserValidation extends Validation
{
	
	public function validations() {
		return [
			'name' => 'nullable|string',
			'username' => 'required|string|unique:users,username',
			'password' => 'required|string|min:8',
			'avatar' => 'nullable|image',
			'level_id' => 'required|numeric'
		];
	}
	
}
