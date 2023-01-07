<?php

namespace App\Strainer;

trait StrainHelper {

	public static function groupTypes (
		string $suptype, string $type, string $subtype
	) {
		return [
			'suptype' => $suptype,
			'type' => $type,
			'subtype' => $subtype,
		];
	}

	/**
	 * Paginate query result
	 * 
	 * @param mixed $query
	 * @param int $perPage
	 * @param int $page
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public static function paginate (mixed $query, int $perPage, int $page) {
		return $query->paginate(perPage: $perPage, page: $page);
	}

	/**
	 * Object to associative array
	 * 
	 * @param mixed $value
	 * @param boolean $assoc
	 * @return array
	 */
	public static function parseAssociate(mixed $value, bool $assoc = true) {
		return json_decode(json_encode($value), $assoc);
	}
	
}
