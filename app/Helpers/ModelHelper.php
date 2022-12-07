<?php

namespace App\Helpers;

class ModelHelper
{

	public static function parseNonAssoc(array $arrays, string $key)
	{
		$new_arrays = [];
		foreach ($arrays as $array) {
			$new_arrays[] = $array[$value ?? 'value'];
		}
		return $new_arrays;
	}

	public static function parseByKey(array $arrays, string $key, string $value)
	{
		$new_arrays = [];
		foreach ($arrays as $array) {
			$new_arrays[$array[$key ?? 'key']] = $array[$value ?? 'value'];
		}
		return $new_arrays;
	}

	public static function getJalur($jalur)
	{
		$str = $jalur->jalur;
		if (isset($jalur->subjalur1)) {
				$str .= ' ' . $jalur->subjalur1;
		} if (isset($jalur->subjalur2) && isset($jalur->subjalur3)) {
				$str .= ' (' . $jalur->subjalur2 . ' Tingkat ' . $jalur->subjalur3 .')';
		} return $str;
	}

}