<?php

namespace App\Helpers;

class NumberHelper
{
	
	public static function toRupiah($price, $prefix = 'Rp')
	{
		return $prefix . number_format($price, 2, ',', '.');
	}
	
}
