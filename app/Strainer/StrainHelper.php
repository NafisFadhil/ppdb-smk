<?php

namespace App\Strainer;

class StrainHelper {

	public static function groupTypes (
		string $suptype, string $type, string $subtype
	) {
		return [
			'suptype' => $suptype,
			'type' => $type,
			'subtype' => $subtype,
		];
	}

	// public static function getType(string $type, array $types) {
		
	// }
	
}
