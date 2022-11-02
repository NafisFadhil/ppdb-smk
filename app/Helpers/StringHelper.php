<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class StringHelper
{

	public static function toTitle(string $str)
	{
		return Str::title(
			Str::replace(['-','_'], ' ', $str)
		);
	}

	public static function toSlug(string $str, string $separator = '-')
	{
		return Str::slug($str, $separator);
	}
	
}