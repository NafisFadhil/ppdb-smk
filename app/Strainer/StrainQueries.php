<?php

namespace App\Strainer;

class StrainQueries {
	
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
	 * Queries of filter will executed
	 * 
	 * @var array $queries
	 */
	public array $queries = [];

	/**
	 * Available all types variant
	 * 
	 * @var array $queries
	 */
	public array $rules = [];
	
	/**
	 * Get wheres collection filter pre-query
	 */
	public function __construct(array $types, array $rules) {
		$this->types = $types;
		$this->rules = $rules;
		$this->suptype = $types['suptype'];
		$this->type = $types['type'];
		$this->subtype = $types['subtype'];

		$this->queries = $this->resolve();
	}

	/**
	 * Checking type and return wheres collection
	 */
	private function resolve () {
		$queries = $this->default();

		// Array replacing
		$method = $this->suptype;
		if (method_exists($this, $method)) {
			// $queries = $this->$method();
			$queries = array_replace($queries, $this->$method());
		}

		$method = $this->type;
		if (method_exists($this, $method)) {
			// $queries = $this->$method();
			$queries = array_replace($queries, $this->$method());
		}
		
		return $queries;
	}

	/**
	 * General wheres filter pre-query
	 * 
	 * @return array
	 */
	private function default () {
		return [
            'periode' => [
				'wheres' => [
					'periode' => []
				]
			],
            'jurusan' => [
                'wheres' => [
                    'whereRelation' => ['jurusan', 'singkatan'],
                ]
            ],
            'jalur' => [
                'wheres' => [
                    'where' => ['jalur_pendaftaran_id'],
                ]
            ],
            'jenis_kelamin' => [
                'wheres' => [
                    'where' => ['jenis_kelamin_id'],
                ]
            ],
            'search' => [
                'variant' => 'midlike',
                'wheres' => [
                    'where' => ['nama_lengkap', 'LIKE'],
                    'orWhere' => ['asal_sekolah', 'LIKE'],
                    'orWhereRelation' => ['pendaftaran', 'kode', 'LIKE'],
                    'orWhereRelation' => ['jurusan', 'kode', 'LIKE'],
                ]
            ],
            'perPage' => ['wheres' => ['perPage' => []]],
            'page' => ['wheres' => ['page' => []]],
        ];
	}

	private function sponsorship () {
		return [
			'search' => [
				'variant' => 'midlike',
				'wheres' => [
					'whereRelation' => ['sponsorship', 'nama', 'LIKE'],
					'orWhereRelation' => ['sponsorship', 'kelas', 'LIKE'],
					'orWhereRelation' => ['sponsorship', 'no_wa', 'LIKE'],
					'orWhereRelation' => ['pendaftaran', 'kode', 'LIKE'],
					'orWhereRelation' => ['jurusan', 'kode', 'LIKE'],
					'orWhere' => ['nama_lengkap', 'LIKE'],
					'orWhere' => ['asal_sekolah', 'LIKE'],
				]
			]
		];
	}

}
