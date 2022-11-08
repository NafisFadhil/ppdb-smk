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

}