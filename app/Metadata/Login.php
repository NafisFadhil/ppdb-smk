<?php

namespace App\Metadata;

class Login
{
	
	public static function inputs ()
	{
		return [
			['type' => 'text', 'name' => 'username'],
			['type' => 'password', 'name' => 'password']
		];
	}

	public static function validator ()
	{
		return [
			'username' => 'required',
			'password' => 'required',
		];
	}
	
}
