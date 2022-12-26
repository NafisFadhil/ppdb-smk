<?php

namespace App\Validations;

abstract class Validation
{

	public static function getValidations(array $names)
    {
		$validations = static::validations();
		
        $results = [];
        foreach ($names as $key) {
            $results[$key] = $validations[$key] ?? '';
        }
        return $results;
    }

	public static function validations () {}
	
}
