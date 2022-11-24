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

	public static function toCapital(string $str)
	{
		return Str::upper($str);
	}

	public static function toSlug(string $str, string $separator = '')
	{
		return Str::slug($str, $separator);
	}

	public static function toJurusan(string $singkatan)
	{
		return \App\Models\Jurusan::getJurusan($singkatan);
	}
	
}