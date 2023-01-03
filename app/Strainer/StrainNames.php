<?php

namespace App\Strainer;

class StrainNames {
	
	/**
	 * Variant of types
	 * 
	 * @var string $suptype
	 * @var string $type
	 * @var string $subtype
	 */
	public string $suptype = '';
	public string $type = '';
	public string $subtype = '';

	/**
	 * Types of filter variants
	 * 
	 * @var array $types
	 */
	public array $types = [];

	/**
	 * Names of filters collection
	 * 
	 * @var array $names
	 */
	public array $names = [];

	/**
	 * Get names of filters will execute
	 */
	public function __construct(array $types) {
		$this->types = $types;
		$this->suptype = $types['suptype'];
		$this->type = $types['type'];
		$this->subtype = $types['subtype'];

		$this->names = $this->resolve();
	}

	/**
	 * Checking types and return the names
	 * 
	 * @return array
	 */
	private function resolve () {
		$names = $this->default();
		
		// if ($this->suptype === 'verifikasi') {
		// 	return $this->verifikasiNames();
		// }

		return $names;
	}

	/**
	 * Names of verifikasi suptype
	 */
	private function default () {
		return [
			'search', 'jurusan', 'jalur', 'periode',
			'jenis_kelamin', 'perPage', 'page',
		];
	}
	
}
